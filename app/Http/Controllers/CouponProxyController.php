<?php

namespace App\Http\Controllers;

use App\Services\ZpCouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponProxyController extends Controller
{
    public function validate(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->input('code', '')));

        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'No code provided.']);
        }

        $result = (new ZpCouponService())->validate($code);

        if ($result === null) {
            return response()->json(['valid' => false, 'message' => 'Could not verify code. Please try again.']);
        }

        return response()->json($result);
    }
}
