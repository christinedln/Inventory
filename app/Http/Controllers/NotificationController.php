<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;


class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Notification::orderBy('notification_id', 'desc')->paginate(10);
        return view('notification', compact('notifications'));
    }

   public function resolve($id)
    {
        $notification = DB::table('notifications')->where('notifiable_id', $id)->first();

        if ($notification && $notification->notifiable_id) {
            $productId = $notification->notifiable_id;

            $position = DB::table('products')
                ->orderBy('product_id', 'desc')
                ->pluck('product_id')
                ->search($productId);

            if ($position !== false) {
                $perPage = 10;
                $page = floor($position / $perPage) + 1;

        
                return redirect()->route('inventory', ['page' => $page])
                 ->with('highlight_id', $productId);
            }
        }

        return redirect()->route('inventory');
    }

}