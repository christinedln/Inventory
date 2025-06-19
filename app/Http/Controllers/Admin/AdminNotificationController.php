<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Http\Controllers\Controller;


class AdminNotificationController extends Controller
{

    /**
     * Display a paginated list of notifications, sorted by newest first.
     */
    public function index()
    {
        $notifications = Notification::orderBy('notification_id', 'desc')->paginate(10);
        return view('admin.adminnotification', compact('notifications'));
    }

     /**
     * Redirect to the correct inventory page that contains the product linked to the notification.
     * Used when resolving a notification related to a product.
     */
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

        
                return redirect()->route('admin.inventory', ['page' => $page])
                 ->with('highlight_id', $productId);
            }
        }

        return redirect()->route('admin.inventory');
    }
    
/**
     * Toggle the notification status between 'resolved' and 'unresolved'.
     */
public function toggleStatus($id)
{
    $notification = Notification::findOrFail($id);

    $notification->status = $notification->status === 'resolved' ? 'unresolved' : 'resolved';
    $notification->save();

    return redirect()->back()->with('success', 'Notification status updated.');
}



}