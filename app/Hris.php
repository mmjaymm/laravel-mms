<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Hris extends Model
{
    protected $connection = 'mysql';

    public function man_power($where)
    {
        return DB::connection('mysql')
        ->table('hris.hrms_emp_masterlist')
        ->select('*')
        ->where($where)->get();
    }

    public function attendances($where)
    {
        return DB::connection('mysql')->select("SELECT emp.*, att.* 
                FROM hris.hrms_emp_masterlist as emp
                LEFT JOIN 
                (
                    (Select  DISTINCT aa.employeeid,aa.emp_last_name,aa.emp_first_name,aa.position,aa.employment_type,aa.section,
                    aa.TIME_IN, bb.TIME_OUT, DATE_FORMAT(aa.DATE_IN, '%Y/%m/%d') AS WORKDATE from
                        (
                            SELECT 
                            a.UserID, 
                            b.emp_last_name, 
                            b.emp_first_name,
                            b.emp_pms_id as employeeid,
                            min(substring(a.Timestamp_ACTAtek,12,5)) AS TIME_IN,
                            min(substring(a.Timestamp_ACTAtek,1,10)) AS DATE_IN,
                            c.position,
                             d.section,
                            e.employment_type
                    
                            FROM hris.agent_log a 
                             
                            left join 
                            hris.pr_sys_employee b
                            on a.UserID = b.emp_card_id
                            left join 
                            hris.pms_employee_position c
                            on c.id = b.emp_position
                            left join 
                            hris.pms_employee_section d
                            on b.emp_section  = d.id
                            left join 
                            hris.pms_employee_employmenttype e
                            on b.emp_employee_type  = e.id
                             
                            where d.section = '{$where->section}'
                            and  a.EventTrigger = 'IN' and
                            substring(a.Timestamp_ACTAtek,1,10) >='{$where->start_date}'
                            and substring(a.Timestamp_ACTAtek,1,10) <='{$where->end_date}'
                            group by b.emp_pms_id
                            order by a.UserID
                        ) aa
                        left join
                        (
                            SELECT 
                            a.UserID, 
                            b.emp_last_name, 
                            b.emp_first_name,
                            b.emp_pms_id as employeeid,
                            max(substring(a.Timestamp_ACTAtek,12,5)) AS TIME_OUT,
                            max(substring(a.Timestamp_ACTAtek,1,10)) AS DATE_OUT,
                            c.position,
                            d.section,
                            e.employment_type
                            FROM hris.agent_log a 
                             
                            left join 
                            hris.pr_sys_employee b
                            on a.UserID = b.emp_card_id
                            left join 
                            hris.pms_employee_position c
                            on c.id = b.emp_position
                            left join 
                            hris.pms_employee_section d
                            on b.emp_section  = d.id
                            left join 
                            hris.pms_employee_employmenttype e
                            on b.emp_employee_type  = e.id
                             
                            where d.section = '{$where->section}' 
                            and  a.EventTrigger = 'OUT' 
                            and substring(a.Timestamp_ACTAtek,1,10)>='{$where->start_date}'
                            and substring(a.Timestamp_ACTAtek,1,10)<='{$where->end_date}'
                            group by b.emp_pms_id
                            order by a.UserID
                        )bb
                         on aa.UserID = bb.UserID AND aa.DATE_IN = bb.DATE_OUT)
                        -- p1 
                   UNION 
                        -- p2
                   (Select  DISTINCT aa.employeeid,aa.emp_last_name,aa.emp_first_name,aa.position,aa.employment_type,aa.section,
                   aa.TIME_IN, bb.TIME_OUT, DATE_FORMAT(aa.DATE_IN, '%Y/%m/%d') AS WORKDATE from
                        (
                            SELECT 
                            a.userid, 
                            b.emp_last_name, 
                            b.emp_first_name,
                            b.emp_pms_id as employeeid,
                            min(substring(a.timeentry,12,5)) AS TIME_IN,
                            min(substring(a.timeentry,1,10)) AS DATE_IN,
                            c.position,
                            d.section,
                            e.employment_type
                            
                            FROM hris.actatek_logs a 
                             
                            left join 
                            hris.pr_sys_employee b
                            on a.UserID = b.emp_card_id
                            left join 
                            hris.pms_employee_position c
                            on c.id = b.emp_position
                            left join 
                            hris.pms_employee_section d
                            on b.emp_section  = d.id
                            left join 
                            hris.pms_employee_employmenttype e
                            on b.emp_employee_type  = e.id
                             
                            where d.section = '{$where->section}'  
                            and  a.eventid = 'IN' 
                            and substring(a.timeentry,1,10)>='{$where->start_date}'
                            and substring(a.timeentry,1,10)<='{$where->end_date}'
                            group by b.emp_pms_id
                            order by a.UserID
                        ) aa
                        left join
                        (
                            SELECT 
                            a.userid, 
                            b.emp_last_name, 
                            b.emp_first_name,
                            b.emp_pms_id as employeeid,
                            max(substring(a.timeentry,12,5)) AS TIME_OUT,
                            max(substring(a.timeentry,1,10)) AS DATE_OUT,
                            c.position,
                            d.section,
                            e.employment_type
                            FROM hris.actatek_logs a 
                             
                            left join 
                            hris.pr_sys_employee b
                            on a.UserID = b.emp_card_id
                            left join 
                            hris.pms_employee_section d
                            on b.emp_section  = d.id
                            left join 
                            hris.pms_employee_position c
                            on c.id = b.emp_position
                            left join 
                            hris.pms_employee_employmenttype e
                            on b.emp_employee_type  = e.id
                             
                            where d.section = '{$where->section}'  
                            and  a.eventid = 'OUT' 
                            and substring(a.timeentry,1,10) >='{$where->start_date}'
                            and substring(a.timeentry,1,10) <='{$where->end_date}'
                            group by b.emp_pms_id
                            order by a.UserID
                        )bb
                         on aa.userid = bb.userid AND aa.DATE_IN = bb.DATE_OUT)
                ) as att
                ON att.employeeid = emp.emp_pms_id
                WHERE emp.section = 'MANUFACTURING INFORMATION TECHNOLOGY' and emp.emp_system_status = 'ACTIVE'");
    }
}