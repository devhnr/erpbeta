<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        @php
            $userId = Auth::id();
            $get_user_data = Helper::get_user_data($userId);
            //echo"<pre>";print_r($get_user_data); echo"</pre>";exit;
            $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
            $permission1 = [];
            if (is_object($get_permission_data) && property_exists($get_permission_data, 'permission') && $get_permission_data->permission !== '') {
                $permission1 = $get_permission_data->permission;
                $permission1 = explode(',', $permission1);
            } else {
                echo '';
                // Handle the case where $get_permission_data is not an object or 'permission' property is empty.
            }
            // echo"<pre>";print_r($permission1);echo"</pre>";
        @endphp
        <ul>
            <li class="{{ request()->segment(1) == 'admin' && request()->segment(2) == '' ? 'active' : '' }}">
                <a href="{{ url('/') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
            </li>
            @if (
                in_array('3', $permission1) ||
                in_array('4', $permission1) ||
                in_array('14', $permission1) ||
                in_array('9', $permission1) ||
                in_array('14', $permission1) ||
                in_array('11', $permission1) ||
                in_array('12', $permission1) ||
                in_array('20', $permission1) ||
                in_array('21', $permission1) ||
                in_array('40', $permission1) ||
                in_array('41', $permission1) ||
                in_array('42', $permission1) 
                )
            <li class="submenu">
                <a href="#"
                    class="{{ request()->segment(1) == 'country' ||
                            request()->segment(1) == 'service' ? 'active' : '' }}">
                    <i data-feather="pie-chart"></i> <span>Master</span> <span class="menu-arrow"></span></a>
                <ul>
                    @if (in_array('7', $permission1))
                        <li class="{{ request()->segment(1) == 'branch' ? 'active' : '' }}">
                            <a href="{{ route('branch.index') }}"
                                class="{{ request()->segment(1) == 'branch' ? 'active' : '' }}">Branch</a>
                        </li>
                    @endif
                    @if (in_array('3', $permission1))
                        <li class="{{ request()->segment(1) == 'country' ? 'active' : '' }}">
                            <a href="{{ route('country.index') }}"
                                class="{{ request()->segment(1) == 'country' ? 'active' : '' }}">Country</a>
                        </li>
                    @endif
                    @if (in_array('4', $permission1))
                        <li class="{{ request()->segment(1) == 'title_rank' ? 'active' : '' }}">
                            <a href="{{ route('title_rank.index') }}"
                                class="{{ request()->segment(1) == 'title_rank' ? 'active' : '' }}">Title/Rank</a>
                        </li>
                    @endif
                    @if (in_array('9', $permission1))
                        <li class="{{ request()->segment(1) == 'surveyor_time_zone' ? 'active' : '' }}">
                            <a href="{{ route('surveyor_time_zone.index') }}"
                                class="{{ request()->segment(1) == 'surveyor_time_zone' ? 'active' : '' }}">Surveyor Time Zone</a>
                        </li>
                    @endif
                    @if (in_array('40', $permission1))
                        <li class="{{ request()->segment(1) == 'vehicles' ? 'active' : '' }}">
                            <a href="{{ route('vehicles.index') }}"
                                class="{{ request()->segment(1) == 'vehicles' ? 'active' : '' }}">Vehicles</a>
                        </li>
                    @endif
                    @if (in_array('41', $permission1))
                        <li class="{{ request()->segment(1) == 'godowns' ? 'active' : '' }}">
                            <a href="{{ route('godowns.index') }}"
                                class="{{ request()->segment(1) == 'godowns' ? 'active' : '' }}">Godown</a>
                        </li>
                    @endif
                    @if (in_array('42', $permission1))
                        <li class="{{ request()->segment(1) == 'materials' ? 'active' : '' }}">
                            <a href="{{ route('materials.index') }}"
                                class="{{ request()->segment(1) == 'materials' ? 'active' : '' }}">Material</a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (in_array('17', $permission1)||
                in_array('19', $permission1)||
                in_array('18', $permission1)
            )
             <li class="submenu">
                <a href="#"
                class="{{ request()->segment(1) == 'industry-type' ||
                request()->segment(1) == 'approved-agents' || request()->segment(1) == 'reference' ? 'active' : '' }}">
                    <i data-feather="layers"></i> <span>Organization Master</span> <span class="menu-arrow"></span></a>
                <ul>
                 @if (in_array('17', $permission1))
                <li class="{{ request()->segment(1) == 'industry-type' ? 'active' : '' }}">
                    <a href="{{ route('industry-type.index') }}"
                        class="{{ request()->segment(1) == 'industry-type' ? 'active' : '' }}">Industry Type</a>
                </li>
                @endif
                @if (in_array('19', $permission1))
                <li class="{{ request()->segment(1) == 'approved-agents' ? 'active' : '' }}">
                    <a href="{{ route('approved-agents.index') }}"
                        class="{{ request()->segment(1) == 'approved-agents' ? 'active' : '' }}">Approved Agents</a>
                </li>
                @endif
                @if (in_array('18', $permission1))
                <li class="{{ request()->segment(1) == 'reference' ? 'active' : '' }}">
                    <a href="{{ route('reference.index') }}"
                        class="{{ request()->segment(1) == 'reference' ? 'active' : '' }}">Reference</a>
                </li>
                 @endif
                </ul>
             </li>

            @endif

            @if (in_array('5', $permission1)||
                in_array('6', $permission1)||
                in_array('23', $permission1)||
                in_array('22', $permission1)||
                in_array('8', $permission1)||
                in_array('10', $permission1)||
                in_array('20', $permission1)||
                in_array('21', $permission1)||
                in_array('11', $permission1)||
                in_array('12', $permission1)||
                in_array('24', $permission1)||
                in_array('25', $permission1)
            )
             <li class="submenu">
                <a href="#"
                class="{{ request()->segment(1) == 'customer_type' ||
                request()->segment(1) == 'service' || request()->segment(1) == 'services-required' || request()->segment(1) == 'description-of-goods' || request()->segment(1) == 'surveyor_type'|| request()->segment(1) == 'storage_type' || request()->segment(1) == 'frequencies' || request()->segment(1) == 'durations' || request()->segment(1) == 'storage_mode' || request()->segment(1) == 'enquiry_mode' || request()->segment(1) == 'source-of-contact' ||  request()->segment(1) == 'product-type' ? 'active' : '' }}">
                    <i data-feather="info"></i> <span>Enquiry Master</span> <span class="menu-arrow"></span></a>
                <ul>
                    {{-- @if (in_array('5', $permission1))
                    <li class="{{ request()->segment(1) == 'customer_type' ? 'active' : '' }}">
                        <a href="{{ route('customer_type.index') }}"
                            class="{{ request()->segment(1) == 'customer_type' ? 'active' : '' }}">Customer Type</a>
                    </li>
                    @endif --}}
                    @if (in_array('6', $permission1))
                    <li class="{{ request()->segment(1) == 'service' ? 'active' : '' }}">
                        <a href="{{ route('service.index') }}"
                            class="{{ request()->segment(1) == 'service' ? 'active' : '' }}">Service Type</a>
                    </li>
                    @endif
                    @if (in_array('23', $permission1))
                        <li class="{{ request()->segment(1) == 'services-required' ? 'active' : '' }}">
                            <a href="{{ route('services-required.index') }}"
                                class="{{ request()->segment(1) == 'services-required' ? 'active' : '' }}">Service Required</a>
                        </li>
                    @endif
                    @if (in_array('22', $permission1))
                    <li class="{{ request()->segment(1) == 'description-of-goods' ? 'active' : '' }}">
                        <a href="{{ route('description-of-goods.index') }}"
                            class="{{ request()->segment(1) == 'description-of-goods' ? 'active' : '' }}">Description Of Goods</a>
                    </li>
                    @endif
                    @if (in_array('8', $permission1))
                    <li class="{{ request()->segment(1) == 'surveyor_type' ? 'active' : '' }}">
                        <a href="{{ route('surveyor_type.index') }}"
                            class="{{ request()->segment(1) == 'surveyor_type' ? 'active' : '' }}">Survey Type</a>
                    </li>
                    @endif
                    @if (in_array('10', $permission1))
                    <li class="{{ request()->segment(1) == 'storage_type' ? 'active' : '' }}">
                        <a href="{{ route('storage_type.index') }}"
                            class="{{ request()->segment(1) == 'storage_type' ? 'active' : '' }}">Storage Type</a>
                    </li>
                    @endif
                    @if (in_array('20', $permission1))
                    <li class="{{ request()->segment(1) == 'frequencies' ? 'active' : '' }}">
                        <a href="{{ route('frequencies.index') }}"
                            class="{{ request()->segment(1) == 'frequencies' ? 'active' : '' }}">Frequency</a>
                    </li>
                    @endif
                    @if (in_array('21', $permission1))
                        <li class="{{ request()->segment(1) == 'durations' ? 'active' : '' }}">
                            <a href="{{ route('durations.index') }}"
                                class="{{ request()->segment(1) == 'durations' ? 'active' : '' }}">Duration</a>
                        </li>
                    @endif
                    @if (in_array('11', $permission1))
                        <li class="{{ request()->segment(1) == 'storage_mode' ? 'active' : '' }}">
                            <a href="{{ route('storage_mode.index') }}"
                                class="{{ request()->segment(1) == 'storage_mode' ? 'active' : '' }}">Storage Mode</a>
                        </li>
                    @endif
                    @if (in_array('24', $permission1))
                        <li class="{{ request()->segment(1) == 'product-type' ? 'active' : '' }}">
                            <a href="{{ route('product-type.index') }}"
                                class="{{ request()->segment(1) == 'product-type' ? 'active' : '' }}">Product Type</a>
                        </li>
                    @endif
                    @if (in_array('25', $permission1))
                    <li class="{{ request()->segment(1) == 'source-of-contact' ? 'active' : '' }}">
                        <a href="{{ route('source-of-contact.index') }}"
                            class="{{ request()->segment(1) == 'source-of-contact' ? 'active' : '' }}">Source Of Contact</a>
                    </li>
                    @endif
                    @if (in_array('12', $permission1))
                        <li  class="{{ request()->segment(1) == 'enquiry_mode' ? 'active' : '' }}">
                            <a href="{{ route('enquiry_mode.index') }}"
                                class="{{ request()->segment(1) == 'enquiry_mode' ? 'active' : '' }}">Enquiry Mode</a>
                        </li>
                    @endif
                </ul>
             </li>
            @endif

            @if (in_array('27', $permission1)||
                in_array('28', $permission1)||
                in_array('29', $permission1)||
                in_array('30', $permission1)||
                in_array('34', $permission1)
                )
            <li class="submenu">
                <a href="#"
                    class="{{ request()->segment(1) == 'movingcost' || request()->segment(1) == 'cbm' || request()->segment(1) == 'cbm-pricing' || request()->segment(1) == 'shipment-type'  ? 'active' : '' }}">
                    <i data-feather="dollar-sign"></i> <span>Costing Master</span> <span class="menu-arrow"></span></a>
                <ul>
                @if (in_array('27', $permission1))
                    <li>
                        <a href="{{ route('movingcost.index') }}"
                            class="{{ request()->segment(1) == 'movingcost' ? 'active' : '' }}">Moving Cost</a>
                    </li>
                @endif
                @if (in_array('28', $permission1))
                    <li>
                        <a href="{{ route('cbm.index') }}"
                            class="{{ request()->segment(1) == 'cbm' ? 'active' : '' }}">CBM</a>
                    </li>
                @endif
                @if (in_array('29', $permission1))
                    <li>
                        <a href="{{ route('cbm-pricing.index') }}"
                            class="{{ request()->segment(1) == 'cbm-pricing' ? 'active' : '' }}">CBM Pricing</a>
                    </li>
                @endif
                @if (in_array('30', $permission1))
                    <li>
                        <a href="{{ route('shipment-type.index') }}"
                            class="{{ request()->segment(1) == 'shipment-type' ? 'active' : '' }}">Shipment Type</a>
                    </li>
                @endif
                @if (in_array('34', $permission1))
                    <li>
                        <a href="{{ route('codes.index') }}"
                            class="{{ request()->segment(1) == 'codes' ? 'active' : '' }}">Code</a>
                    </li>
                @endif
                </ul>
            </li>
            @endif

             @if(in_array('14', $permission1) ||
                in_array('15', $permission1) ||
                in_array('16', $permission1) ||
                in_array('26', $permission1) ||
                in_array('31', $permission1) ||
                in_array('32', $permission1)
             )
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'agent' || 
                                  request()->segment(1) == 'followup' || 
                                  request()->segment(2) == 'survey' || 
                                  request()->segment(2) == 'enquiry-detail' || 
                                  request()->segment(2) == 'survey-detail' || 
                                  request()->segment(2) == 'costing' || 
                                  request()->segment(2) == 'costing-add' || 
                                  request()->segment(2) == 'costing-detail' || 
                                  request()->segment(2) == 'quotation' || 
                                  request()->segment(2) == 'quotation-detail' || 
                                  request()->segment(2) == 'quotation-add' || 
                                  request()->segment(2) == 'customer-mail' || 
                                  request()->segment(1) == 'agent-detail' || 
                                  request()->segment(2) == 'revise-request' ? 'active' : '' }}">
                        <i data-feather="shopping-bag"></i> <span> Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if (in_array('14', $permission1))
                            <li class="{{ request()->segment(1) == 'agent' || request()->segment(1) == 'agent-detail' ? 'active' : '' }}">
                                <a href="{{ route('agent.index') }}"
                                    class="{{ request()->segment(1) == 'agent' || request()->segment(1) == 'agent-detail' ? 'active' : '' }}">Organization</a>
                            </li>
                        @endif
                        @if (in_array('15', $permission1))
                            <li class="{{ request()->segment(1) == 'followup' || request()->segment(1) == 'surveyor_form' || request()->segment(2) == 'enquiry-detail'  ? 'active' : '' }}">
                                <a href="{{ route('followup.index') }}"
                                    class="{{ request()->segment(1) == 'followup' || request()->segment(1) == 'costing' || request()->segment(1) == 'surveyor_form' || request()->segment(2) == 'enquiry-detail' ? 'active' : '' }}">Enquiry</a>
                            </li>
                        @endif
                        @if (in_array('26', $permission1))
                            <li class="{{ request()->segment(2) == 'survey' || request()->segment(1) == 'survey_info' || request()->segment(2) == 'survey-detail' ? 'active' : '' }}">
                                <a href="{{ route('survey.index') }}"
                                    class="{{ request()->segment(2) == 'survey' || request()->segment(1) == 'survey_info' || request()->segment(2) == 'survey-detail' ? 'active' : '' }}">Survey</a>
                            </li>
                        @endif
                        @if (in_array('31', $permission1))
                            <li class="{{ request()->segment(2) == 'costing' || request()->segment(2) == 'costing-add' || request()->segment(2) == 'costing-detail' ? 'active' : '' }}">
                                <a href="{{ route('costing.index') }}"
                                    class="{{ request()->segment(2) == 'costing' || request()->segment(2) == 'costing-detail' ? 'active' : '' }}">Costing</a>
                            </li>
                        @endif
                        @if (in_array('32', $permission1))
                            <li class="{{ request()->segment(2) == 'quotation' || request()->segment(2) == 'quotation-detail' || request()->segment(2) == 'quotation-add' || request()->segment(2) == 'customer-mail' || request()->segment(2) == 'revise-request' ? 'active' : '' }}">
                                <a href="{{ route('quote.index') }}"
                                    class="{{ request()->segment(2) == 'quotation' || request()->segment(2) == 'quotation-detail' || request()->segment(2) == 'quotation-add' || request()->segment(2) == 'customer-mail' || request()->segment(2) == 'revise-request' ? 'active' : '' }}">Quotation</a>
                            </li>
                        @endif
                        {{-- @if (in_array('16', $permission1))
                            <li class="{{ request()->segment(1) == 'survey_assign' ? 'active' : '' }}">
                                <a href="{{ route('survey_assign.index') }}"
                                    class="{{ request()->segment(1) == 'survey_assign' ? 'active' : '' }}">Surveys</a>
                            </li>
                        @endif --}}
                    </ul>
                </li>
            @endif
            @if (in_array('35', $permission1) || in_array('36', $permission1) || in_array('37', $permission1) || in_array('44', $permission1))
            <li class="submenu">
                <a href="#" class="{{ request()->segment(2) == 'accepted-quotation' || request()->segment(1) == 'job-order' || request()->segment(2) == 'add-man-power' || request()->segment(2) == 'add-vehicles' || request()->segment(2) == 'add-packing-material' || request()->segment(2) == 'operation-detail' || request()->segment(2) == 'add-label' || request()->segment(2) == 'add-documents' || request()->segment(2) == 'get-report' || request()->segment(2) == 'shipment' || request()->segment(2) == 'shipment-detail' || request()->segment(2) == 'billing-invoice' ? 'active' : '' }}">
                    <i data-feather="users"></i> <span> Customer Service</span> <span class="menu-arrow"></span>
                </a>
                <ul>
                    @if (in_array('35', $permission1))
                        <li class="{{ request()->segment(1) == 'accepted-quotation' ? 'active' : '' }}">
                            <a href="{{ route('accepted-quotation.index') }}"
                                class="{{ request()->segment(1) == 'accepted-quotation' ? 'active' : '' }}">
                                {{-- <i class="fa fa-check-circle"></i> --}} Accepted Quotation
                            </a>
                        </li>
                    @endif
                    @if (in_array('36', $permission1))
                        <li class="{{ request()->segment(1) == 'job-order' ? 'active' : '' }}">
                            <a href="{{ route('job-order.index') }}"
                                class="{{ request()->segment(1) == 'job-order' ? 'active' : '' }}">
                                {{-- i class="fa fa-solid fa-briefcase"></i> --}} Job Order
                            </a>
                        </li>
                    @endif
                    @if (in_array('37', $permission1))
                        <li class="{{ request()->segment(1) == 'operation' || request()->segment(2) == 'add-man-power' || request()->segment(2) == 'add-vehicles' || request()->segment(2) == 'add-packing-material' || request()->segment(2) == 'operation-detail' || request()->segment(2) == 'add-label' || request()->segment(2) == 'add-documents' || request()->segment(2) == 'get-report' ? 'active' : '' }}">
                            <a href="{{ route('operation.index') }}"
                                class="{{ request()->segment(1) == 'operation' || request()->segment(2) == 'add-man-power' || request()->segment(2) == 'add-vehicles' || request()->segment(2) == 'add-packing-material' || request()->segment(2) == 'operation-detail' || request()->segment(2) == 'add-label' || request()->segment(2) == 'add-documents' || request()->segment(2) == 'get-report' ? 'active' : '' }}">
                                Operation
                            </a>
                        </li>
                    @endif
                    @if (in_array('44', $permission1))
                        <li class="{{ request()->segment(2) == 'shipment' || request()->segment(2) == 'shipment-detail' ? 'active' : '' }}">
                            <a href="{{ route('shipment.index') }}"
                                class="{{ request()->segment(2) == 'shipment' || request()->segment(2) == 'shipment-detail' ? 'active' : '' }}">
                                Shipment
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (in_array('46', $permission1) || in_array('45', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'billing-invoice' || 
                                  request()->segment(2) == 'invoice-bill'    ||
                                  request()->segment(2) == 'company-account-details' ? 'active' : '' }}">
                        <i data-feather="clipboard"></i> <span> Billing</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if (in_array('46', $permission1))
                            <li class="{{ request()->segment(2) == 'billing-invoice' || request()->segment(2) == 'invoice-bill' || request()->segment(2) == 'invoice-report' ? 'active' : '' }}">
                                <a href="{{ route('billing-invoice.index') }}"
                                    class="{{ request()->segment(2) == 'billing-invoice' || request()->segment(2) == 'invoice-bill' || request()->segment(2) == 'invoice-report' ? 'active' : '' }}">
                                    {{-- <i class="fa fa-hand-o-up"></i>--}} Invoice 
                                </a>
                            </li>
                        @endif
                        @if (in_array('45', $permission1))
                            <li class="{{ request()->segment(2) == 'company-account-details' ? 'active' : '' }}">
                                <a href="{{ route('companyAccountDetails.edit', 1) }}"
                                    class="{{ request()->segment(2) == 'company-account-details' ? 'active' : '' }}"> 
                                    {{-- <i class="fa fa-bank"></i> --}}
                                    Company Bank Account Details</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (in_array('1', $permission1) || 
                 in_array('2', $permission1) || 
                 in_array('13', $permission1) || 
                 in_array('38', $permission1) || 
                 in_array('39', $permission1)  
                )
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'userpermission' || request()->segment(2) == 'adminuser' ? 'active' : '' }}">
                        <i data-feather="user"></i> <span> User Management</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if (in_array('1', $permission1))
                            <li class="{{ request()->segment(1) == 'userpermission' ? 'active' : '' }}">
                                <a href="{{ route('userpermission.index') }}"
                                    class="{{ request()->segment(1) == 'userpermission' ? 'active' : '' }}">
                                    <i class="fa fa-hand-o-up"></i> User Permission
                                </a>
                            </li>
                        @endif
                        @if (in_array('2', $permission1))
                            <li class="{{ request()->segment(1) == 'adminuser' ? 'active' : '' }}">
                                <a href="{{ route('adminuser.index') }}"
                                    class="{{ request()->segment(1) == 'adminuser' ? 'active' : '' }}"><i
                                        data-feather="lock"></i> Admin User </a>
                            </li>
                        @endif

                        @if (in_array('13', $permission1))
                            <li class="{{ request()->segment(1) == 'surveyor' ? 'active' : '' }}">
                                <a href="{{ route('surveyor.index') }}"
                                    class="{{ request()->segment(1) == 'surveyor' ? 'active' : '' }}"> <i class="fa fa-users"></i> Surveyor</a>
                            </li>
                        @endif
                        @if (in_array('38', $permission1))
                            <li class="{{ request()->segment(1) == 'supervisor' ? 'active' : '' }}">
                                <a href="{{ route('supervisor.index') }}"
                                    class="{{ request()->segment(1) == 'supervisor' ? 'active' : '' }}"> <!-- <i class="fa fa-users"></i> -->
                                    <img width="20" height="20" src="https://img.icons8.com/external-outline-lafs/64/external-ic_supervisor-blockchain-outline-lafs.png" alt="external-ic_supervisor-blockchain-outline-lafs"/>
                                    Crew Leader</a>
                            </li>
                        @endif
                        @if (in_array('39', $permission1))
                            <li class="{{ request()->segment(1) == 'men-power' ? 'active' : '' }}">
                                <a href="{{ route('men-power.index') }}"
                                    class="{{ request()->segment(1) == 'men-power' ? 'active' : '' }}"> <!-- <i class="fa fa-users"></i> -->
                                    <img width="20" height="20" src="https://img.icons8.com/external-outline-lafs/64/external-ic_supervisor-blockchain-outline-lafs.png" alt="external-ic_supervisor-blockchain-outline-lafs"/>
                                    Man Power</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
