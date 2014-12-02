<?php 
/**
 * 1. This is for the documentation of the whole code file
 * meditell
 *
 * An application/platform that helps in drug reminding.
 *
 * @package		meditell
 * @author		Meditell Nigeria Product Development Team
 * @copyright	Copyright (c) 2014, Meditell Nigeria.
 * @link		http://meditell.com.ng
 * @since		Version 1.0 (alpha)
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * meditell HospitalModelClass/Model
 *
 * This class serves as a class for the Hospital to create Appointment
 * 
 *
 * @package		meditell
 * @subpackage	Models
 * @category	Models
 * @author		Ayegbayo Olutimileyin
 * @link		http://twitter/_asquo
 */
	class HospitalModel extends CI_Model
	{
		//to ensure that everything gotten from the database belongs to a specific hospital, the $hospitalId variable has been used to check out this. 
		var $hospitalId = 'H2001';
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		///<summary>
		///Function Name: createAppointmentType
		///This function help the hospital to create a type of appointment
		///Parameters:
		///		$title: the title/name of the Appointment Group
		///		$description: A short description for the Appointment Group. 
		///</summary>	
		function createAppointmentType($title,$description)
		{
			$this->db->set('appointment_type_id','');
			$this->db->set('appointment_name',$title);
			$this->db->set('hospital_id',$this->hospitalId);
			$this->db->set('description',$description);
			return $this->db->insert('appointment_type');
		}
		
		///<summary>
		///Function Name: setAppointment
		///This function helps the hospital to create a type of appointment
		///Parameters:
		///		$appointmentType: the type of appointment to be set for the patient.
		///		$doctorId: Identification of the doctor involved in the appointment.
		///		$patientId: Identification of the patient involved in the appointment.
		///		$appointmenthour: The hour the appointment was set for.
		///		$appointment_minute: The minute the appointment was set for.
		/// 	$appointmentday: The day the appointment was set for.
		///		$appointmentmonth: The day the appointment was set for.
		///		$meridian: The meridian the appointment was set for: AM or PM.
		///</summary>
		function setAppointment($appointmentType,$appointmenthour,$appointment_minute,$appointmentday,$appointmentmonth,$appointmentyear,$doctor,$patientId,$notify,$meridian)
		{
			if($notify == on)
			{
				//Notify patient of Appointment Immediately. 
			} 
			$data = array('appointment_type'=>$appointmentType,'notification_sent'=>$notify,'appointment_hour'=>$appointmenthour,'appointment_minute'=>$appointment_minute,'appointment_month'=>$appointmentmonth,'appointment_day'=>$appointmentday,'appointment_year'=>$appointmentyear,'meridian'=>$meridian,'hospital_id'=>$this->hospitalId,'doctor'=>$doctor,'patient_id'=>$patientId); 		
			$this->db->insert('appointments',$data);
		}
		
		
		///<summary>
		///Function Name: viewAppointments
		///This function helps the hospital staff to view appointments that have been set for patient
		///Parameters:
		///		$appointmentId: The Id for the appointments whose details is to be viewed
		///</summary>
		function viewAppointments($appointmentId)
		{
			if($appointmentId != NULL)
			{
				$searchcriteria = array('hospital_id'=>$this->hospitalId,'appointment_id'=>$appointmentId);
			}
			else
			{
				$searchcriteria = array('hospital_id'=>$this->hospitalId);
			}
			$this->db->where($searchcriteria);
			$query = $this->db->get('appointments');
			return $query->result();
		}
		

		///<summary>
		///Function Name: checkDoctorSchedule
		///checks the schedule for doctor with $doctor and determines of an appointment can be scheduled for him/her  
		///Parameters:
		///		$doctor: the doctor whose schedule is to be checked
		///		$date: the date for which the schedule should be checked;
		///		$time: the time to check for the schedule
		///</summary>	
		function checkDoctorSchedule($doctor,$year,$month,$day,$hour,$minute)
		{
			$searchcriteria = array('doctor'=>$doctor,'appointment_year'=>$year,'appointment_month'=>$month,'appointment_day'=>$day);
			$this->db->where($searchcriteria);
			$query = $this->db->get('appointments');
			return $query->result();
		}
		
		
		///<summary>
		///Function Name: viewAppointmenttypes
		///This function helps the hospital staff to view appointment type created by the hospital
		///Parameters:
		///</summary>
		function viewAppointmentTypes($appointmentTypeId)
		{
			if($appointmentTypeId == NULL)
			{
				$searchcriteria = array('hospital_id'=>$this->hospitalId);
			}
			else
			{
				$searchcriteria = array('hospital_id'=>$this->hospitalId,'appointment_type_id'=>$appointmentTypeId);
			}
				$query = $this->db->where($searchcriteria);
				$query = $this->db->get('appointment_type');
				return $query->result();
		}
		
		
		///<summary>
		///Function Name: editAppointmenttypes
		///This function helps the hospital staff to edit appointment type created by the hospital
		///Parameters:
		///		
		///</summary>
		function editAppointmentTypes($appointmentName,$appointmentTypeId,$description)
		{
			$data= array('appointment_name'=>$appointmentName,'description'=>$description);
			$this->db->set($data);
			$this->db->where('appointment_type_id',$appointmentTypeId);
			$this->db->update("appointment_type");
		}
		
		///<summary>
		///Function Name: deleteAppointmenttypes
		///This function helps the hospital staff to delete appointment types created by the hospital
		///Parameters:
		///		$appointmentTypeId: The id for the appointment group to be deleted.
		///</summary>
		function deleteAppointmentType($appointmentTypeId)
		{
			$criteria= array('appointment_id'=>$appointmentTypeId,'hospital_id'=>$this->hospital_id);
			$this->db->where($criteria);
			return $this->db->delete('appointment_type');
		}
		
		///<summary>
		///Function Name: viewAppointmenttypes
		///This function helps the hospital staff to delete appointments set for patients by the hospital
		///		Parameters: 
		///			$appointmentId:	The Id for the appointment to be deleted
		///</summary>
		function deleteAppointment($appointmentId)
		{
			//Confirm deletion before finally deleting appointment;.
				$criteria= array('appointment_id'=>$appointmentId,'hospital_id'=>$this->hospitalId);
				$this->db->where($criteria);
				return $this->db->delete('appointments');
		}
		
		///<summary>
		///Function Name: editAppointment
		///This function helps the hospital staff to edit appointment set for patients created by the hospital
		///Parameters:
		///			$appointmentId: the Id for the appointment to be edited
		///			$patientId: The new pateientId that is going to be assigned to the appointment
		///			$appointmentHour: The new time(hour) for the appointment
		///			$appointmentMinute: The new time(minute) for the appointment
		///			$appointmentDay: The new Day set for the appointment.
		///			$appointmentMonth: The new Month set for the appointment
		///			$appointmentYear:The new Year set for the appointment.
		///</summary>
		function editAppointment($appointmentId,$doctor,$patientId,$appointmentHour,$appointmentMinute,$appointmentDay,$appointmentMonth,$appointmentYear,$appointmentType)
		{
				$this->db->where("appointment_id",$appointmentId);
				$updatedata = array('hospital_id'=>$this->hospitalId,'doctor'=>$doctor,'patient_id'=>$patientId,'appointment_hour'=>$appointmentHour,'appointment_minute'=>$appointmentMinute,'appointment_day'=>$appointmentDay,'appointment_Month'=>$appointmentMonth,'appointment_year'=>$appointmentYear,'appointment_type'=>$appointmentType);		
				$this->db->update('appointments',$updatedata);
		}
	}
?>
