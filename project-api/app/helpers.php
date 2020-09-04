<?php
/**
 *
 * 返回数据封装
 *
 * @param int $code
 * @param string $message
 * @param mixed $data
 * @param bool $other
 * @return Illuminate\Http\JsonResponse
 * @author jreey and @ifehrim
 */
if (!function_exists("response_json")) {
    function response_json($first = 200, $message = "success", $data = null, $arr = [], $header = [])
    {
        $param = func_get_args();
        if (is_string($first)) {
            $message = $first;
            $first = 200;
            if (isset($param[1])) {
                $data = $param[1];
                $arr = [];
            }
            if (isset($param[2])) {
                $arr = $param[2];
            }
        }
        if (is_array($first) || is_object($first)) {
            $data = $first;
            $message = "success";
            $first = 200;
            $arr = [];
            if (isset($param[1])) {
                $arr = $param[1];
            }
        }

        if ($message == "success" && $first != 200) {
            $message = "failed";
        }


        $array = array(
            'status_code' => $first,
            'status' => $message == "success" ? "操作成功" : ($message == "failed" ? "操作失败" : $message),
        );
        if (!empty($data) && !is_null($data)) {
            $array['data'] = $data;
        }
        if (is_array($arr)) {
            $array = array_merge($array, $arr);
        }
        return response()->json($array, 200 , ['token'=> $header['token'] ?? '']);
    }
}