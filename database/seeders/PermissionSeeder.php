<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_VIEW],
            ['description' => 'View user role data', 'module' => 'user-access', 'feature' => 'role']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_CREATE],
            ['description' => 'Create user role data', 'module' => 'user-access', 'feature' => 'role']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_EDIT],
            ['description' => 'Edit user role data', 'module' => 'user-access', 'feature' => 'role']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_DELETE],
            ['description' => 'Delete user role data', 'module' => 'user-access', 'feature' => 'role']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::USER_VIEW],
            ['description' => 'View user account data', 'module' => 'user-access', 'feature' => 'user']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::USER_CREATE],
            ['description' => 'Create user account data', 'module' => 'user-access', 'feature' => 'user']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::USER_EDIT],
            ['description' => 'Edit user account data', 'module' => 'user-access', 'feature' => 'user']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::USER_DELETE],
            ['description' => 'Delete user account data', 'module' => 'user-access', 'feature' => 'user']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::DOCUMENT_TYPE_VIEW],
            ['description' => 'View document type data', 'module' => 'master', 'feature' => 'document-type']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::DOCUMENT_TYPE_CREATE],
            ['description' => 'Create document type data', 'module' => 'master', 'feature' => 'document-type']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::DOCUMENT_TYPE_EDIT],
            ['description' => 'Edit document type data', 'module' => 'master', 'feature' => 'document-type']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::DOCUMENT_TYPE_DELETE],
            ['description' => 'Delete document type data', 'module' => 'master', 'feature' => 'document-type']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_TYPE_VIEW],
            ['description' => 'View booking type data', 'module' => 'master', 'feature' => 'booking-type']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_TYPE_CREATE],
            ['description' => 'Create booking type data', 'module' => 'master', 'feature' => 'booking-type']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_TYPE_EDIT],
            ['description' => 'Edit booking type data', 'module' => 'master', 'feature' => 'booking-type']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_TYPE_DELETE],
            ['description' => 'Delete booking type data', 'module' => 'master', 'feature' => 'booking-type']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::CUSTOMER_VIEW],
            ['description' => 'View customer data', 'module' => 'master', 'feature' => 'customer']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::CUSTOMER_CREATE],
            ['description' => 'Create customer data', 'module' => 'master', 'feature' => 'customer']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::CUSTOMER_EDIT],
            ['description' => 'Edit customer data', 'module' => 'master', 'feature' => 'customer']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::CUSTOMER_DELETE],
            ['description' => 'Delete customer data', 'module' => 'master', 'feature' => 'customer']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::CONTAINER_VIEW],
            ['description' => 'View container data', 'module' => 'master', 'feature' => 'container']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::CONTAINER_CREATE],
            ['description' => 'Create container data', 'module' => 'master', 'feature' => 'container']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::CONTAINER_EDIT],
            ['description' => 'Edit container data', 'module' => 'master', 'feature' => 'container']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::CONTAINER_DELETE],
            ['description' => 'Delete container data', 'module' => 'master', 'feature' => 'container']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::GOODS_VIEW],
            ['description' => 'View goods data', 'module' => 'master', 'feature' => 'goods']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::GOODS_CREATE],
            ['description' => 'Create goods data', 'module' => 'master', 'feature' => 'goods']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::GOODS_EDIT],
            ['description' => 'Edit goods data', 'module' => 'master', 'feature' => 'goods']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::GOODS_DELETE],
            ['description' => 'Delete goods data', 'module' => 'master', 'feature' => 'goods']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::UPLOAD_VIEW],
            ['description' => 'View upload data', 'module' => 'document', 'feature' => 'upload']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::UPLOAD_CREATE],
            ['description' => 'Create upload data', 'module' => 'document', 'feature' => 'upload']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::UPLOAD_EDIT],
            ['description' => 'Edit upload data', 'module' => 'document', 'feature' => 'upload']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::UPLOAD_DELETE],
            ['description' => 'Delete upload data', 'module' => 'document', 'feature' => 'upload']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::UPLOAD_VALIDATE],
            ['description' => 'Validate upload data', 'module' => 'document', 'feature' => 'upload']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_VIEW],
            ['description' => 'View booking data', 'module' => 'booking', 'feature' => 'booking']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_CREATE],
            ['description' => 'Create booking data', 'module' => 'booking', 'feature' => 'booking']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_EDIT],
            ['description' => 'Edit booking data', 'module' => 'booking', 'feature' => 'booking']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_DELETE],
            ['description' => 'Delete booking data', 'module' => 'booking', 'feature' => 'booking']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::BOOKING_VALIDATE],
            ['description' => 'Validate booking data', 'module' => 'booking', 'feature' => 'booking']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::DELIVERY_ORDER_VIEW],
            ['description' => 'View delivery order data', 'module' => 'delivery-order', 'feature' => 'delivery-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::DELIVERY_ORDER_CREATE],
            ['description' => 'Create delivery order data', 'module' => 'delivery-order', 'feature' => 'delivery-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::DELIVERY_ORDER_EDIT],
            ['description' => 'Edit delivery order data', 'module' => 'delivery-order', 'feature' => 'delivery-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::DELIVERY_ORDER_DELETE],
            ['description' => 'Delete delivery order data', 'module' => 'delivery-order', 'feature' => 'delivery-order']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::WORK_ORDER_VIEW],
            ['description' => 'View work order data', 'module' => 'work-order', 'feature' => 'work-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::WORK_ORDER_CREATE],
            ['description' => 'Create work order data', 'module' => 'work-order', 'feature' => 'work-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::WORK_ORDER_EDIT],
            ['description' => 'Edit work order data', 'module' => 'work-order', 'feature' => 'work-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::WORK_ORDER_DELETE],
            ['description' => 'Delete work order data', 'module' => 'work-order', 'feature' => 'work-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::WORK_ORDER_TAKE],
            ['description' => 'Take work order data', 'module' => 'work-order', 'feature' => 'work-order']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::WORK_ORDER_VALIDATE],
            ['description' => 'Validate work order data', 'module' => 'work-order', 'feature' => 'work-order']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::TAKE_STOCK_VIEW],
            ['description' => 'View take stock data', 'module' => 'take-stock', 'feature' => 'take-stock']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::TAKE_STOCK_CREATE],
            ['description' => 'Create take stock data', 'module' => 'take-stock', 'feature' => 'take-stock']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::TAKE_STOCK_EDIT],
            ['description' => 'Edit take stock data', 'module' => 'take-stock', 'feature' => 'take-stock']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::TAKE_STOCK_DELETE],
            ['description' => 'Delete take stock data', 'module' => 'take-stock', 'feature' => 'take-stock']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::TAKE_STOCK_VALIDATE],
            ['description' => 'Validate take stock data', 'module' => 'take-stock', 'feature' => 'take-stock']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::REPORT_INBOUND],
            ['description' => 'Report inbound', 'module' => 'report', 'feature' => 'report-inbound']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::REPORT_OUTBOUND],
            ['description' => 'Report outbound', 'module' => 'report', 'feature' => 'report-outbound']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::REPORT_STOCK_SUMMARY],
            ['description' => 'Report stock summary', 'module' => 'report', 'feature' => 'report-stock-summary']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::REPORT_STOCK_MOVEMENT],
            ['description' => 'Report stock movement', 'module' => 'report', 'feature' => 'report-stock-movement']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::ACCOUNT_EDIT],
            ['description' => 'Edit account data', 'module' => 'preferences', 'feature' => 'account']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::SETTING_EDIT],
            ['description' => 'Edit setting data', 'module' => 'preferences', 'feature' => 'setting']
        );

    }
}
