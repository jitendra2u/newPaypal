<?php 
public function zones()
                {              
                //die;
                if($this->request->is('get'))
                {
                    $this->loadModel('Tickets');
                    $token='';
                    $reqL='';
                    $reqParam=$this->getParameter();
                    if($reqParam!='')
                    {
                         $aRow = $this->Tickets->query("select id,name from loc_zones where status=true");
                            if(count($aRow)!=0)
                            {
                                for($i=0;$i < count($aRow ); $i++)
                                {
                                    $aDatass['zones'][$i]['id']=$aRow[$i][0]['id'];
                                    $aDatass['zones'][$i]['name']=$aRow[$i][0]['name'];
                                    $res['code']  = 0;
                                    $res['message']  = '';
                                    $data = $aDatass;
                                    $res['data'] = $data;
                                }
                            }
                    }
                    else
                    {
                        $res=$this->errorCode(115);
                    }
                        }
                        else
                        {
                            $res=$this->errorCode(102);
                        }
                    //$chunk="Action:disposType"." "."Token_".$token."Time_".date("Y-m-d h:i:a")."Req_".$reqL."Res_"."Code:".$res['code'].' '."Message".$res['message'];
                    //$this->writeLogFile($chunk);
                $this->getResponse($res);
                }
              
                public function fsoAvailable()
                {
                 //http://localhost/mcrm_test/fsoAvailable/date/28-01-2017/time/11
                                
                    if($this->request->is('get'))
                    {
                        $token='';
                        $reqL='';
                        $reqParam=$this->getParameter();
                        if($reqParam!='')
                        {
                            //$reqL = implode(', ', array_map(function ($v, $k) { return $k . '=' . $v; }, $reqParam, array_keys($reqParam)));
            
                            if(array_key_exists('date',$reqParam))
                            {
                                            $sCurDate=$reqParam['date'];
                            
                            }
                            if(array_key_exists('zone',$reqParam))
                            {
                                            $zoneId1=$reqParam['zone'];
                            
                            }
                            if(array_key_exists('time',$reqParam))
                            {
                                            $ts=$reqParam['time'].':00';
                            
                            }
                            $appDate=$sCurDate.' '.$reqParam['time'].':00:00';
                            $appDate=date('Y-m-d H:i:s',strtotime($appDate));
                            
                            //"2017-02-03 17:00:00"
                            
                            $this->loadModel('Tickets');
                                
                                                                                
             $aUsers = $this->Tickets->query("SELECT  distinct concat(u.\"firstName\",' ',u.\"lastName\",'(',u.username,')') as username,u.id as id from users as u 
                                              inner join agent_areas as atr on atr.\"userId\" = u.id                                                                                                   
                                            where u.active=1 and u.\"roleId\" in(1,2,3,4) and  atr.\"zoneId\" = '$zoneId1' 
                                             and u.\"userGroupId\"!='113'  ");
                $i=0;                                                                                                      
                if(isset($aUsers) && !empty($aUsers))
                {
                    foreach($aUsers as $iKey => $aUser)
                    {
                        //echo "SELECT id, timeslot FROM timeslots where status = true and timeslot='".$ts."'";die;
                            $aTimeSlots = $this->Tickets->query("SELECT id, timeslot FROM timeslots where status = true and timeslot='".$ts."'");
                                //pr($aTimeSlots);die;
                                //echo "select count(*) as total from tickets where \"appointmentDate\" = '".$appDate."'  and \"assignedTo\" = ".$aUser[0]['id']."";
                                                                
                            $aCheck = $this->Tickets->query("select count(*) as total from tickets where \"appointmentDate\" = '".$appDate."'  and \"assignedTo\" = ".$aUser[0]['id']."");
            
                            //$aTicket = $this->Tickets->query("select id from tickets where \"appointmentDate\" = '".$appDate."' and \"assignedTo\" = ".$aUser[0]['id']."");
                            
                            //$aRows['user']["a".$aUser[0]['id']]['Name'] = $aUser[0]['firstName'] . ' ' .$aUser[0]['lastName'];
                            
                            if($aCheck[0][0]['total'] == 0)
                            {
                                            
                                            $aRows['user'][$i]['id'] = $aUser[0]['id'];
                                            $aRows['user'][$i]['Name'] = $aUser[0]['username'] ;
                                            $i=$i+1;

                                            
                                            //$aRows['user']["a".$aUser[0]['id']][$aTimeSlots[0][0]['timeslot']] = $aTicket[0][0]['id'];
                            }
                                                                                                                
                                                                                
                                                                                //}
                                                                }
                                                                //die;
                                                }
                                                else{
                                                                
                                                                $aRows['user'] = '';
                                                }
                                                                //pr($aRows);die;
                                                                $res['code']        = 0;
                                                                $res['message']                = '';
                                                                $data                                     = $aRows;
                                                                $res['data']    = $data;
                                                                
                                                }
                                                else
                                                {
                                                                $res=$this->errorCode(115);
                                                }
                                
                
                                }
                                else
                                {
                                                $res=$this->errorCode(102);
                                }
                                                //$chunk             ="Action:Gizmohelptimeslots"." "."Token_".$token."Time_".date("Y-m-d h:i:a")."Req_".$reqL."Res_"."Code:".$res['code'].' '."Message".$res['message'];
                                                //$this->writeLogFile($chunk);
                                                $this->getResponse($res);
                }
                
                public function createTickets()
                {
                                if ($this->request->is('post')) 
                                {
                                $this->loadModel('Tickets');
                                $reqParam= $this->request->input('json_decode');
                                                                
                                                

                                                                
                                                $mobext = $this->Tickets->query("select id from customers where mobile = '".$reqParam->customermobile."' ");
                                                if(empty($mobext[0][0]['id']))
                                                {
                                                                $aCustId=$this->Tickets->query("insert into customers (mobile,\"customerName\",email,\"customerSource\",\"processId\") values (".$reqParam->customermobile.", '".$reqParam->customername."', '".$reqParam->customeremail."',7,12) RETURNING id");
                                                                $custId=$aCustId[0][0]['id'];
                                                                
                                                }
                                                else
                                                {
                                                                $custId = $mobext[0][0]['id'];
                                                }
                                                
                                                
                                
                                $data['Tickets']['customerId']= $custId;
                                $data['Tickets']['categoryId']= $reqParam->categoryId;
                                $data['Tickets']['subCategoryId'] =$reqParam->subCategoryId;
                                $data['Tickets']['ticketCategoryId'] = $reqParam->ticketCategoryId;
                                $data['Tickets']['ticketSubcategoryId']   = $reqParam->ticketSubcategoryId;
                                $data['Tickets']['dispositionId'] = $reqParam->dispositionId;
                                $data['Tickets']['assignedTo']  = $reqParam->assignedTo;;
                                $data['Tickets']['createdBy']           = 13183;
                                $data['Tickets']['priority']           = "LOW";
                                $data['Tickets']['ticketStatus']           = "Pending";
                                $data['Tickets']['appointmentDate'] = $reqParam->appointmentDate;
                                $visitDate=date('d/m/Y',strtotime($reqParam->appointmentDate));
                                $data['Tickets']['visitDate']=$visitDate;
                                $data['Tickets']['assignedTimeSlot']=date('H:00', strtotime($reqParam->appointmentDate)).':00';
                                $data['Tickets']['modifiedDate']=date('Y-m-d H:i:s');
                                $data['Tickets']['createdDate']=date('Y-m-d H:i:s');
                                //pr($data['Tickets']);die;
                                if(in_array(null, $data['Tickets'], false))
                                {
                                                $res['code'] = 0;
                                                $res['message'] = 'Invalid parameter';
                                                $res['data'] = "";
                                }
                                else
                                {
                                                $this->Tickets->create($this->data);
                                                $this->Tickets->save($data);
                                                
                                                $res['code'] = 0;
                                                $res['message'] = 'Created successfully';
                                                $res['data'] = "";
                                }
                                                                
                                                
                                                                
                                                                
                                                }
                                else
                                {
                                                $res=$this->errorCode(102);
                                }
                                                
                                //$chunk             ="Action:createEMSUsers"." "."Token_No needed"."Time_".date("Y-m-d h:i:a")."Req_".$reqL."Res_"."Code:".$res['code'].' '."Message".$res['message'];
                                //$this->writeLogFile($chunk);
                                $this->getResponse($res);
                }

?>