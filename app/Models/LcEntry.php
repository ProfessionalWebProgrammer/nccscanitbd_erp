<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcEntry extends Model
{
    use HasFactory;
    protected $table = 'lc_entries';
    protected $fillable=['user_id','date','shipment_date','acceptance_date','payment_date','issues_bank_id','beneficiary_bank_id','discounting_bank_id','confirming_bank_id','agent_bank_id','lc_group_id','lc_ledger_id','lc_number',
    'exporter_id','hs_code','country','item_id','lc_qty','receive_qty','usd_rate','usd_value','bdt_rate','bdt_value','cnf_name_id','mother_vessel_id','port_of_entry_id','port_of_discharge_id','payment_bank_id','amount','remarks','status'];

    public function lcGroup(){
        return $this->belongsTo(LcGroup::class,'lc_group_id' , 'id');
    }
    public function lcLedger(){
        return $this->belongsTo(LcLedger::class,'lc_ledger_id' , 'id');
    }

    public function issuesBank(){
        return $this->belongsTo(MasterBank::class,'issues_bank_id' , 'bank_id');
    }

    public function beneficiaryBank(){
        return $this->belongsTo(MasterBank::class,'beneficiary_bank_id' , 'bank_id');
    }
    public function discountingBank(){
        return $this->belongsTo(MasterBank::class,'discounting_bank_id' , 'bank_id');
    }
    public function confirmingBank(){
        return $this->belongsTo(MasterBank::class,'confirming_bank_id' , 'bank_id');
    }
    public function paymentBank(){
        return $this->belongsTo(MasterBank::class,'payment_bank_id' , 'bank_id');
    }
    public function agentBank(){
        return $this->belongsTo(AgentBank::class,'agent_bank_id' , 'id');
    }
    public function exporteLedger(){
        return $this->belongsTo(ExporterLedger::class,'exporter_id' , 'id');
    }
    public function item(){
        return $this->belongsTo(RowMaterialsProduct::class,'item_id' , 'id');
    }
    public function cnf(){
        return $this->belongsTo(CnfName::class,'cnf_name_id' , 'id');
    }
    public function motherVessel(){
        return $this->belongsTo(MotherVessel::class,'mother_vessel_id' , 'id');
    }
    public function portOfEntry(){
        return $this->belongsTo(PortOfEntry::class,'port_of_entry_id' , 'id');
    }
    public function portOfDischarge(){
        return $this->belongsTo(PortOfDischarge::class,'port_of_discharge_id' , 'id');
    }

}
