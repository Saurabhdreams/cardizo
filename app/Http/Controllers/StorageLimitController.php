<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\Vcard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StorageLimitController extends AppBaseController
{
    public function index()
    {
        $storageLimit = getCurrentSubscription()->plan->storage_limit;
         $productStorageMB = isset(totalStorageData()['product_storage']) ? totalStorageData()['product_storage'] / (1024 * 1024) : 0;
         $serviceStorageMB = isset(totalStorageData()['services_storage']) ? totalStorageData()['services_storage'] / (1024 * 1024) : 0;
         $testimonialStorageMB = isset(totalStorageData()['testimonial_storage']) ? totalStorageData()['testimonial_storage'] / (1024 * 1024) : 0;
         $socialStorageMB = isset(totalStorageData()['social_storage']) ? totalStorageData()['social_storage'] / (1024 * 1024) : 0;
         $blogStorageMB = isset(totalStorageData()['blog_storage']) ? totalStorageData()['blog_storage'] / (1024 * 1024) : 0;
         $galleryStorageMB = isset(totalStorageData()['gallery_storage']) ? totalStorageData()['gallery_storage'] / (1024 * 1024) : 0;
         $profileStorageMB = isset(totalStorageData()['profile_storage']) ? totalStorageData()['profile_storage'] / (1024 * 1024) : 0;
         $pwaStorageMB = isset(totalStorageData()['pwa_storage']) ? totalStorageData()['pwa_storage'] / (1024 * 1024) : 0;
         $avatarStorageMB = isset(totalStorageData()['avatar_storage']) ? totalStorageData()['avatar_storage'] / (1024 * 1024) : 0;
        return view('storage.index', compact('storageLimit','blogStorageMB','productStorageMB','serviceStorageMB', 'testimonialStorageMB','socialStorageMB','galleryStorageMB','profileStorageMB','pwaStorageMB','avatarStorageMB'));
    }
    public function storageChart() : JsonResponse
    {

         $planStorage = getCurrentSubscription()->plan->storage_limit;
         $userLimit =totalStorage();
         $storage = $userLimit * 100 / $planStorage;
         // $labels = ['Used storage', 'Unused Storage'];d

         $labels = [
                  Lang::get('messages.used_storage'),
                  Lang::get('messages.unused_storage'),
              ];

         // Assign data and labels to the response
         $data = [
             'labels' => $labels,
             'data' => [$storage, 100 - $storage],
         ];

         return $this->sendResponse($data, 'storage chart data fetch successfully.');

    }
}
