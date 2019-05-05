<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('array_from_post')) {
    function array_from_post($fields)
    {
        $data = new stdClass;
        $CI = &get_instance();
        foreach ($fields as $field) {
            $data->{$field} = $CI->input->post($field);
        }
        return $data;
    }
}

if (!function_exists('array_from_get')) {
    function array_from_get($fields)
    {
        $data = new stdClass;
        $CI = &get_instance();
        foreach ($fields as $field) {
            $data->{$field} = $CI->input->get($field);
        }
        return $data;
    }
}

if (!function_exists('_success')) {
    function _success($message = 'success', $data = null, $string = false, $json = true)
    {
        $output = new stdClass;
        $output->err = 0;
        $output->msg = $string == false ? lang($message) : $message;
        $output->data = $data;

        return $json == true ? json_encode($output) : $output;
    }
}

if (!function_exists('_error')) {
    function _error($message = 'error', $data = null, $string = false, $json = true)
    {
        $message = $message instanceof \Illuminate\Support\MessageBag ? $message : [[$string == false ? lang($message) : $message]];

        $output = new stdClass;
        $output->err = 1;
        $output->msg = $message;
        $output->data = $data;

        !$json || http_response_code(422);
        return $json == true ? json_encode($output) : $output;
    }
}

if (!function_exists('random_string')) {
    function random_string($length = 8)
    {
        return bin2hex(random_bytes($length));
    }
}

if (!function_exists('encrypt_hash')) {
    function encrypt_hash($string, $hash_key)
    {
        return hash('sha512', $string . $hash_key . config_item('encryption_key'));
    }
}

if (!function_exists('hash_token')) {
    function hash_token()
    {
        return md5(uniqid(rand(), true));
    }
}

if (!function_exists('json_validate')) {
    function json_validate($string)
    {
        $result = json_decode($string);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occurred.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            exit(_error(null, $error, true, true));
        }

        // everything is OK
        return $result;
    }
}

if (!function_exists('download_file')) {
    function download_file($file, $name, $mime_type = '')
    {
        //Check the file permission
        if (!is_readable($file)) {
            die('File not found or inaccessible!');
        }

        $size = filesize($file);
        $name = rawurldecode($name);

        /* Figure out the MIME type | Check in array */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "xlxs" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain",
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($file, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            }
            ;
        }
        ;

        //turn off output buffering to decrease cpu usage
        @ob_end_clean();

        // required for IE, otherwise Content-Disposition may be ignored
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        /* The three lines below basically make the
        download non-cacheable */
        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        // multipart-download and download resuming support
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        /* Will output the file itself */
        $chunksize = 10 * (1024 * 1024); //you may want to change this
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE'])) {
                fseek($file, $range);
            }

            while (!feof($file) &&
                (!connection_aborted()) &&
                ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // can also possible
                flush();
                $bytes_send += strlen($buffer);

            }
            fclose($file);
        }
        //If no permissiion
        else {
            die('Error - can not open file.');
        }
        die();
    }
}

if (!function_exists('send_email')) {
    function send_email($template = false, $to_email = false, $subject = false, $config_arr = [], $attachments = [])
    {
        $CI = &get_instance();

        return $CI->mailer
            ->to($to_email)
            ->subject($subject)
            ->attach($attachments)
            ->send($template, $config_arr);
    }
}

if (!function_exists('sanitize_string')) {
    function sanitize_string($value = '')
    {
        return xss_clean(trim($value));
    }
}

if (!function_exists('filter_number')) {
    function filter_number($number = false)
    {
        $order = array("-", ",", ".", "(", ")", "[", "]", "{", "}", " ", "_", "+");
        $replace = '';
        $number = str_replace($order, $replace, $number);
        if (!is_numeric($number)) {
            $number = "";
        }
        return $number;
    }
}

if (!function_exists('api_response')) {
    function api_response($status = false, $message = 'success', $dataArr = [], $string = false)
    {
        return [
            'status' => (int) $status,
            'message' => $string == false ? lang($message) : $message,
            'data' => $dataArr,
        ];
    }
}

if (!function_exists('upload_image')) {
    function upload_image($file_name = false, $directory_path = '/assets/uploads/images')
    {
        $directory_path = realpath('') . $directory_path;
        $CI = &get_instance();

        if (!is_dir($directory_path)) {
            mkdir($directory_path, 0755, true);
        }

        $config = [];
        $config['upload_path'] = $directory_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['remove_spaces'] = true;
        $config['encrypt_name'] = true;
        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload($file_name)) {
            log_message('error', $CI->upload->display_errors());
            return null;
        }

        $fileArr = $CI->upload->data();
        return $fileArr['file_name'];
    }
}

if (!function_exists('send_notification')) {
    function sendPushNotification($fcm_id = array(), $dataArr = array(), $device_type = false)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = config_item('fcm_legacy_key');

        $notification = [
            'title' => $dataArr['title'],
            'en_title' => $dataArr['en_title'],
            'body' => $dataArr['body'],
            'en_body' => $dataArr['en_body'],
            'notification_type' => $dataArr['notification_type'],
            'notification_to' => $dataArr['notification_to'],
            'extra_data' => $dataArr,
        ];

        $arrayToSend = [
            'registration_ids' => is_array($fcm_id) ? $fcm_id : [$fcm_id],
            'priority' => "high",
            'data' => $notification,
        ];

        $headers = [
            'Content-Type:application/json',
            'Authorization:key=' . $api_key,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayToSend));

        $result = curl_exec($ch);
        if ($result === false) {
            $result = curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('utf8_strrev')) {
    function utf8_strrev($str)
    {
        preg_match_all('/./us', $str, $ar);
        return join('', array_reverse($ar[0]));
    }
}

if (!function_exists('get_lang')) {
    function get_lang()
    {
        $culture = get_instance()->session->userdata('lang');
        return in_array($culture, ['en', 'ar']) ? $culture : 'en';
    }
}

if (!function_exists('getTimeDiff')) {
    function getTimeDiff($input = '')
    {
        return $input ? \Carbon\Carbon::createFromTimeStamp(strtotime($input))->diffForHumans() : '';
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($input = '', $to_format = 'Y-m-d H:i:s', $from_format = 'Y-m-d H:i:s')
    {
        return $input ? \Carbon\Carbon::createFromFormat($from_format, $input)->format($to_format) : '';
    }
}

if (!function_exists('getBtwDays')) {
    function getBtwDays($from_date = null, $to_date = null)
    {
        if (!$from_date || !$to_date) {
            return 0;
        }

        $from_date = new DateTime($from_date);
        $to_date = new DateTime($to_date);
        $interval = $from_date->diff($to_date);
        return $interval->format('%a');
    }
}

if (!function_exists('getSessionUser')) {
    function getSessionUser($column = null)
    {
        return empty($column) ? get_instance()->session->userdata('admin') : get_instance()->session->userdata('admin')->{$column};
    }
}

if (!function_exists('updateUserSession')) {
    function updateUserSession()
    {
        $CI = &get_instance();
        $user_id = getSessionUser('id');
        $admin = \Models\Admin::find($user_id);
        $CI->session->set_userdata('admin', $admin);
        return true;
    }
}

if (!function_exists('redirectIfNull')) {
    function redirectIfNull($id = null, $url = null)
    {
        if (empty($id) || !is_numeric($id)) {
            redirect(site_url($url), 'refresh');
        }
        return true;
    }
}

if (!function_exists('blank')) {
    /**
     * Determine if the given value is "blank".
     *
     * @param  mixed  $value
     * @return bool
     */
    function blank($value)
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('collect')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    function collect($value = null)
    {
        return new Collection($value);
    }
}

if (!function_exists('show404')) {
    function show404()
    {
        get_instance()->load->view('errors/html/custom404', true);
    }
}
