<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class UserHelper {
    public static function getUser() {
        if ( ! isset($_GET['token'])) {
            return false;
        }
        $token = trim($_GET['token']);

        if (empty($token)) {
            return false;
        }
        $user = DB::table('users')->where('token', $token)->first();
        return $user;
    }

    public static function can($levels) {
        $canAccess = false;
        $user = self::getUser();

        if ( ! in_array($user->level, $levels)) {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode([
                'status' => 403,
                'message' => 'Access Denied !'
            ]);
            exit(0);
        }

        return true;
    }
}
