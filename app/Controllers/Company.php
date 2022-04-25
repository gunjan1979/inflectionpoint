<?php namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Company extends BaseController
{
    public function company_management()
    {
        $crud = new GroceryCrud();

        $crud->setTable('company');
        $crud->setSubject('Company', 'Company');
        $crud->columns(['company_name', 'cohort','actions']);
        //$crud->unsetDelete();

        // $crud->setActionButton('View', 'bi bi-eye', function ($row) {
        //     return 'inflectionpointlist/' . $row->id;
        // }, false);
        $crud->callbackColumn('actions',array($this,'_callback_webpage_url'));
        $crud->unsetEdit();
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

    public function _callback_webpage_url($value, $row)
    {
    return "<a href='".site_url('company/inflectionpointlist/'.$row->id)."'>View</a>";
    }

    public function inflectionpointlist($id)
    {
        $crud = new GroceryCrud();
        //$crud->setTheme('datatables');
        $crud->setTable('company_inflection_point');
        $crud->setSubject('Inflection points', 'company_inflection_point');
        $crud->columns(['company_id', 'ip_id','ip_score']);
        $crud->displayAs('company_id','Company');
        $crud->displayAs('ip_id','Inflection Point');
        $crud->setRelation('company_id','company','company_name');
        $crud->setRelation('ip_id','inflection_point','ip_name');
        $crud->where('company_inflection_point.company_id',$id);  
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->unsetAddFields(['crt_ts', 'upd_ts']);
        $crud->unsetEditFields(['crt_ts', 'upd_ts']);
        $crud->requiredFields(['company_id','ip_id']);
        $output = $crud->render();
        
        return $this->_exampleOutput($output);
    }

    public function inflectionpoints()
    {
        $crud = new GroceryCrud();

        $crud->setTable('company_inflection_point');
        $crud->setSubject('Inflection points', 'company_inflection_point');
        $crud->columns(['company_id', 'ip_id','ip_score']);
        $crud->setRelation('company_id','company','company_name');
        $crud->setRelation('ip_id','inflection_point','ip_name');
        $crud->unsetAddFields(['crt_ts', 'upd_ts']);
        $crud->unsetEditFields(['crt_ts', 'upd_ts']);
        $crud->requiredFields(['company_id','ip_id']);
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

    private function _exampleOutput($output = null)
    {
        return view('company', (array) $output);
    }

}
