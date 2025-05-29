<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'agent_type',
        'company_name',
        'p_o_c_full',
        'p_o_c_position_title',
        'company_email',
        'company_telephone',
        'country',
        'company_city',
        'company_role',
        'active_inactive',
        'approved_agent',
        'approved_by',
        'company_payment_terms',
        'company_vat_num',
        'bill_company_through',
        'client_source',
        'company_address',
        'parent_company',
        'years_in_business',
    ];
}
