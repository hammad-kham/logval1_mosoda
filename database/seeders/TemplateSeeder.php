<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 0;

        //SMS
        {
            $type++;
            $type_for = 0;

            // SOD Fixed Orders
            {
                $array = array();

                $title = 'Waiting';
                $description = 'Dear Homely user, you have Created new order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Cancelled';
                $description = 'Dear Homely user, you have Cancelled your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Confirmed';
                $description = 'Dear Homely user, you have Confirmed your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Declined';
                $description = 'Dear Homely user, your order [ORDERNO] has been Declined.';
                $array[$title] = $description;

                $title = 'Accepted';
                $description = 'Dear Homely user, your order [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Team Left';
                $description = 'Dear Homely user, Team Left for your location against your order [ORDERNO].';
                $array[$title] = $description;

                $title = 'Team Reached';
                $description = 'Dear Homely user, Team Reached to your location against your order [ORDERNO].';
                $array[$title] = $description;

                $title = 'Delivered';
                $description = 'Dear Homely user, Service requested against your order [ORDERNO] is Delivered.';
                $array[$title] = $description;

                $title = 'Completed';
                $description = 'Dear Homely user, You have confirmed that Service requested against your order [ORDERNO] is Delivered.';
                $array[$title] = $description;


                $type_for++;
                $status = 0;
                foreach($array as $title => $description)
                {
                    $status++;
                    $this->create_template($type, $type_for, $status, $title, $description);

                }
            }


            // SOD Request Quotation
            {
                $array = array();

                $title = 'Waiting';
                $description = 'Dear Homely user, you have Requested for Quotation. Request number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Cancelled';
                $description = 'Dear Homely user, you have Cancelled your Request for Quotation. Request number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Requested';
                $description = 'Dear Homely user, you have Requested for Quotation. Request number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Declined';
                $description = 'Dear Homely user, your Request for Quotation [ORDERNO] has been Declined.';
                $array[$title] = $description;

                $title = 'Accepted';
                $description = 'Dear Homely user, your Request for Quotation [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Preparing';
                $description = 'Dear Homely user, Quotation against your order [ORDERNO] is being prepared.';
                $array[$title] = $description;

                $title = 'Submitted';
                $description = 'Dear Homely user, Quotation against your order [ORDERNO] has been submitted.';
                $array[$title] = $description;

                $title = 'Quote Accepted';
                $description = 'Dear Homely user, Quotation against your order [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Quote Rejected';
                $description = 'Dear Homely user, Quotation against your order [ORDERNO] has been Rejected.';
                $array[$title] = $description;


                $type_for++;
                $status = 0;
                foreach($array as $title => $description)
                {
                    $status++;
                    $this->create_template($type, $type_for, $status, $title, $description);

                }
            }

            // Ecommerce Orders
            {
                $array = array();

                $title = 'Waiting';
                $description = 'Dear Homely user, you have Created new order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Cancelled';
                $description = 'Dear Homely user, you have Cancelled your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Confirmed';
                $description = 'Dear Homely user, you have Confirmed your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Declined';
                $description = 'Dear Homely user, a product in your order [ORDERNO] has been Declined';
                $array[$title] = $description;

                $title = 'Accepted';
                $description = 'Dear Homely user, a product in  your order [ORDERNO] has been Accepted';
                $array[$title] = $description;

                $title = 'Ready to Ship';
                $description = 'Dear Homely user, a product in  your order [ORDERNO] is Ready to Ship';
                $array[$title] = $description;

                $title = 'Shipped';
                $description = 'Dear Homely user, a product in  your order [ORDERNO] has been Shipped';
                $array[$title] = $description;

                $title = 'Deliverey Failed';
                $description = 'Dear Homely user a product in , Delivery against your order [ORDERNO] is failed.';
                $array[$title] = $description;

                $title = 'Delivered';
                $description = 'Dear Homely user, a product in  your order [ORDERNO] is Delivered.';
                $array[$title] = $description;

                $title = 'Received';
                $description = 'Dear Homely user, You have confirmed that a product in your order [ORDERNO] is Received.';
                $array[$title] = $description;

                $title = 'Returned';
                $description = 'Dear Homely user, You have returned a product in your order [ORDERNO].';
                $array[$title] = $description;

                $title = 'Return Rejected';
                $description = 'Dear Homely user,your Request for Return [ORDERNO] has been Rejected.';
                $array[$title] = $description;

                $title = 'Return Accepted';
                $description = 'Dear Homely user,your Request for Return [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Waiting for Refund';
                $description = 'Dear Homely user, your Request for Return [ORDERNO] has been Accepted and Waiting for Refund.';
                $array[$title] = $description;

                $title = 'Refunded';
                $description = 'Dear Homely user, your Request for Refund in order [ORDERNO] has been Accepted and Refunded.';
                $array[$title] = $description;


                $type_for++;
                $status = 0;
                foreach($array as $title => $description)
                {
                    $status++;
                    $this->create_template($type, $type_for, $status, $title, $description);

                }
            }
        }

        //Email
        {
            $type++;
            $type_for = 0;

            // SOD Fixed Orders
            {
                $array = array();

                $title = 'Homely: New Order [ORDERNO] Created';
                $description = 'You have Created new order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Cancelled';
                $description = 'You have Cancelled your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Confirmed';
                $description = 'You have Confirmed your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Declined';
                $description = 'Your order [ORDERNO] has been Declined.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Accepted';
                $description = 'Your order [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Homely: Team Left for Order [ORDERNO]';
                $description = 'Team Left for your location against your order [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Team Reached for Order [ORDERNO]';
                $description = 'Team Reached to your location against your order [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Service for Order [ORDERNO] Delivered';
                $description = 'Service requested against your order [ORDERNO] is Delivered.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Completed';
                $description = 'You have confirmed that Service requested against your order [ORDERNO] is Delivered.';
                $array[$title] = $description;


                $type_for++;
                $status = 0;
                foreach($array as $title => $description)
                {
                    $status++;
                    $this->create_template($type, $type_for, $status, $title, $description);

                }
            }


            // SOD Request Quotation
            {
                $array = array();

                $title = 'Homely: New Request for Quotation [ORDERNO] Created';
                $description = 'You have Requested for Quotation. Request number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Request for Quotation [ORDERNO] Cancelled';
                $description = 'You have Cancelled your Request for Quotation. Request number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Quotation Request [ORDERNO] Created';
                $description = 'You have Requested for Quotation. Request number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Request for Quotation [ORDERNO] Declined';
                $description = 'Your Request for Quotation [ORDERNO] has been Declined.';
                $array[$title] = $description;

                $title = 'Homely: Request for Quotation [ORDERNO] Accepted';
                $description = 'Your Request for Quotation [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Homely: Preparing Quotation against [ORDERNO]';
                $description = 'Quotation against your order [ORDERNO] is being prepared.';
                $array[$title] = $description;

                $title = 'Homely: Quotation against [ORDERNO] Submitted';
                $description = 'Quotation against your order [ORDERNO] has been submitted.';
                $array[$title] = $description;

                $title = 'Homely: Quotation against [ORDERNO] Accepted';
                $description = 'Quotation against your order [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Homely: Quotation against [ORDERNO] Rejected';
                $description = 'Quotation against your order [ORDERNO] has been Rejected.';
                $array[$title] = $description;


                $type_for++;
                $status = 0;
                foreach($array as $title => $description)
                {
                    $status++;
                    $this->create_template($type, $type_for, $status, $title, $description);

                }
            }

            // Ecommerce Orders
            {
                $array = array();

                $title = 'Homely: New Order [ORDERNO] Created';
                $description = 'You have Created new order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Cancelled';
                $description = 'You have Cancelled your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Confirmed';
                $description = 'You have Confirmed your order. Order number is [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Declined';
                $description = 'Your order [ORDERNO] has been Declined.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Accepted';
                $description = 'Your order [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Ready to Ship';
                $description = 'Your order [ORDERNO] is Ready to Ship';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Shipped';
                $description = 'Your order [ORDERNO] has been Shipped';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Deliverey Failed';
                $description = 'Delivery against your order [ORDERNO] is failed.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Delivered';
                $description = 'Your order [ORDERNO] is Delivered.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Received';
                $description = 'You have confirmed that your order [ORDERNO] is Received.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Returned';
                $description = 'You have returned your order [ORDERNO].';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Return Rejected';
                $description = 'Your Request for Return [ORDERNO] has been Rejected.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Return Accepted';
                $description = 'Your Request for Return [ORDERNO] has been Accepted.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Waiting for Refund';
                $description = 'Your Request for Return [ORDERNO] has been Accepted and Waiting for Refund.';
                $array[$title] = $description;

                $title = 'Homely: Order [ORDERNO] Refunded';
                $description = 'Your Request for Refund [ORDERNO] has been Accepted and Refunded.';
                $array[$title] = $description;


                $type_for++;
                $status = 0;
                foreach($array as $title => $description)
                {
                    $status++;
                    $this->create_template($type, $type_for, $status, $title, $description);

                }
            }
        }
    }

    private function create_template($type, $type_for, $status, $title, $description)
    {
        $description = $this->get_description($type,$description);

        $model = new Template();
        $model->type = $type;
        $model->type_for = $type_for;
        $model->status = $status;
        $model->title = $title;
        $model->description = $description;
        $model->created_by = 1;
        $model->save();
    }

    private function get_description($type, $description)
    {
        if($type == 2){

            $description_content = $description;

            $description = "<b>Dear Homely user,</b><br>";

            $description = $description."".$description_content;

            $description = $description."<br><br>
            For Any Inquiry, Please do not hesitate to contact us at <b>info@homely.com</b> <br>
            Copyright © 2022, HOMELY <br>
            All Rights Reserved
            <br><br><br>
            <b>DISCLAIMER:</b><br>
            The information contained in this message is confidential.The dissemination, distribution,copying or disclosure of this message, or its contents is strictly prohibited unless authorized by Homely. If you have received this message in error, please return it to the sender at the above address.
            ";
        }

        return $description;
    }
}