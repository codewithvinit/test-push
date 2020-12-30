<?php
namespace Plugins\GPGCheckout\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GPGCheckoutController extends Controller
{
    public function handleCheckout(Request $request)
    {
        if (!empty($request->input('key')) and !empty($request->input('x_receipt_link_url'))) {
            $twoco_args = http_build_query($request->input(), '', '&');
            return redirect($request->input('x_receipt_link_url') . "&" . $twoco_args);
        }
        return redirect("/");
    }

    public function handleCallback(Request $request){
        return response()->json($request->input());
    }
}
