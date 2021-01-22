<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvoiceSetting extends Model
{
    protected $fillable = ['user_id','invoice_due_days','invoice_terms','logo','logo_left','logo_center','logo_right','logo_bg','logo_opacity','logo_hight','logo_width','invoice_font_size','invoice_font_weight','invoice_font_size_1','invoice_font_size_2','invoice_font_size_3','invoice_font_weight_1','invoice_font_weight_2','invoice_heading_title_color','invoice_heading_date_color','invoice_heading_email_color','invoice_heading_gst_color','setPaper'];
}
