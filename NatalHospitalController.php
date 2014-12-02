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
 * meditell NatalHospitalController/Controller
 *
 * This class serves as a controller for the Hospital
 * 
 *
 * @package		meditell
 * @subpackage	Models
 * @category	Models
 * @author		Ayegbayo Olutimileyin
 * @Note: 		Proper OOP should be implemented.
 * @link		http://twitter.com/_asquo
 */
	class NatalHospitalController extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('NatalHospitalModel');
			$this->load->library('form_validation');
		}
		
		function index()
		{
			$this->NatalHospitalModel->updatepregnancydata();
			$this->load->view("natalpages/templates/header");
			$this->load->view("natalpages/index");
			$this->load->view("natalpages/templates/footer");
		}
		
		function register()
		{
			$this->form_validation->set_rules('firstName','Patient Firstname','required');
			$this->form_validation->set_rules('surName','Patient Surname','required');
			$this->form_validation->set_rules('adviceType','Advice type','required');
			$this->form_validation->set_rules('patientAge','Patient Age','required');
			$this->form_validation->set_rules('pregnancyAge','Pregnancy Age','required');
			$this->form_validation->set_rules('mobileNumber','Mobile Number','required');
			
			if($this->form_validation->run() == TRUE)
			{
				$this->NatalHospitalModel->registerPatient($this->input->post('firstName'),$this->input->post('surName'),$this->input->post('patientAge'),$this->input->post('pregnancyAge'),$this->input->post('adviceType'),$this->input->post('mobileNumber'),$this->input->post('vacTips'),$this->input->post('pregTips'));
				echo "Patient Succefully Added";
			}
			else
			{
				$this->index();
			}
		}
		
		function viewPatients()
		{
				$data['patientsdetails'] = $this->NatalHospitalModel->viewRegisteredPatients(); 
				$this->load->view('natalpages/templates/header');
				$this->load->view('natalpages/view_patients',$data);
				$this->load->view('natalpages/templates/footer');
		}
		
		function newVaccineForm()
		{
			$this->load->view("natalpages/templates/header");
			$this->load->view("natalpages/new_vaccine");
			$this->load->view("natalpages/templates/footer");
		}
		
		function addNewVaccine()
		{
			$this->form_validation->set_rules('vaccine_name','Vaccine Name','required');
			$this->form_validation->set_rules('start_age','Start Age','required');
			$this->form_validation->set_rules('end_age','End Age','required');
			$this->form_validation->set_rules('duration','Duration Type','required');
			if($this->form_validation->run() == TRUE)
			{
				echo $this->input->post('duration');
				$this->NatalHospitalModel->newVaccine($this->input->post('vaccine_name'),$this->input->post('start_age'),$this->input->post('end_age'),$this->input->post('duration'));
				echo "Vaccine Added Successfully.";
			}
			else
			{
				$this->newVaccineForm();
			}
		}
		
		function msg()
			{
				$this->NatalHospitalModel->preparePregnancyTips();
			}
		
		function newPregnancyTipsform()
		{
			$this->load->view("natalpages/templates/header");
			$this->load->view("natalpages/newpregnancytips");
			$this->load->view("natalpages/templates/footer");
		}
		
		function newPregnancyTips()
		{
				$this->form_validation->set_rules('tip',"Tip","required");
				$this->form_validation->set_rules('min', "Minimum Pregnancy Age","required");
				$this->form_validation->set_rules('max','Maximum Pregnancy Age',"required");
				$this->form_validation->set_rules('frequency','Frequency','required');
				if($this->form_validation->run() == TRUE)
				{
					$this->NatalHospitalModel->newPregnancyTip($this->input->post('tip'),$this->input->post('frequency'),$this->input->post('max'),$this->input->post('min'));
					echo "Tip successfully created";
				}
				else
				{
					$this->newPregnancyTipsform();
				}
		}
		
		function viewPregnancyTips()
		{
			$data['pregnancy_tips'] = $this->NatalHospitalModel->viewPregnancyTips();
			$this->load->view('natalpages/templates/header');
			$this->load->view('natalpages/pregnancytips',$data);
			$this->load->view('natalpages/templates/footer');
		}
		
		function deleteVaccine()
		{
			$this->NatalHospitalModel->deleteVaccine($this->input->post('vaccine_id'));
			$this->viewVaccines();
		}
		
		function deletePregnancyTip()
		{
			$this->NatalHospitalModel->deletePregnancyTip($this->input->post('tips_id'));
			$this->viewPregnancyTips();
		}
		
		function viewVaccines()
		{
				$data['vaccine_details'] = $this->NatalHospitalModel->viewVaccines(); 
				$this->load->view('natalpages/templates/header');
				$this->load->view('natalpages/viewvaccine',$data);
				$this->load->view('natalpages/templates/footer');
		}
		
		function displaymessage()
		{

			echo sizeof($this->NatalHospitalModel->preparePregnancyTips());
		}
	}
?>
