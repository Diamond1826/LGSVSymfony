<?php

namespace DHLGSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DHLGSVBundle\Entity\Tenant;
use DHLGSVBundle\Form\TenantType;
use DHLGSVBundle\Entity\House;
use DHLGSVBundle\Form\HouseType;
use DHLGSVBundle\Entity\Apartment;
use DHLGSVBundle\Form\ApartmentType;
use DHLGSVBundle\Entity\Allocation;
use DHLGSVBundle\Form\AllocationType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use DHLGSVBundle\Repository\TenantRepository;

class TenantController extends Controller
{
	/**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$tenants = $em->getRepository('DHLGSVBundle:Tenant')->findAll();

        $houses = $em->getRepository('DHLGSVBundle:House')->findAll();

        $apartments = $em->getRepository('DHLGSVBundle:Apartment')->findAll();

        $allocations = $em->getRepository('DHLGSVBundle:Allocation')->findAll();
 
        return array('tenants' => $tenants, 'houses' => $houses, 'apartments' => $apartments, 'allocations' => $allocations);
    }

    /**
     * @Route("/apartments/view/{house}", name="view_apartments")
     * @Template()
     */
    public function viewApartmentsAction($house)
    {
        $em = $this->getDoctrine()->getManager();
        
        $apartments = $em->getRepository(apartment::class)->findBy(array('house' => $house));

        $allocations = $em->getRepository('DHLGSVBundle:Allocation')->findBy(array('apartment' => $apartments));
 
        return array('apartments' => $apartments, 'allocations' => $allocations);
    }

    /**
     * @Route("/allocations/view/{tenant}", name="view_allocations")
     * @Template()
     */
    public function viewAllocationsAction($tenant)
    {
        $em = $this->getDoctrine()->getManager();

        $tenants = $em->getRepository('DHLGSVBundle:Tenant')->findOneById($tenant);
 
        return array('tenants' => $tenants);
    }

    /**
     * @Route("/tenants/view/{apartment}", name="view_tenants")
     * @Template()
     */
    public function viewTenantsAction($apartment)
    {
        $em = $this->getDoctrine()->getManager();

        $apartments = $em->getRepository('DHLGSVBundle:Allocation')->findBy(array('apartment' => $apartment));;
 
        return array('apartments' => $apartments);
    }

	/**
     * @Route("/tenant/add", name="new_tenant")
     * @Template()
     */
    public function newTenantAction(Request $request) 
    { 
    	$tenant = new Tenant();
 
    	$form = $this->createForm(TenantType::class, $tenant);
 
    	$form->handleRequest($request);
 
    	if ($form->isSubmitted() && $form->isValid()) 
        { 
    		$em = $this->getDoctrine()->getManager();
 
    		$em->persist($tenant);
 
    		$em->flush();
 
    		return $this->redirectToRoute('home');
    	}
 
    	return array('form' => $form->createView());
    }

    /**
     * @Route("/house/add", name="new_house")
     * @Template()
     */
    public function newHouseAction(Request $request) 
    { 
        // Create "dummy"-House as reference
        $house = new House();
 
        // Create new Form based on HouseType
        $form = $this->createForm(HouseType::class, $house);
 
        // Handle Request (if form is sent)
        $form->handleRequest($request);
 
        // if form is sent and data is valid ...
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            // Get EntityManager 
            $em = $this->getDoctrine()->getManager();
 
            // Pass House to EntityManager
            $em->persist($house);
 
            // Write House on database
            $em->flush();
 
            // redirect to startpage
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }

    /**
     * @Route("/allocation/add", name="new_allocation")
     * @Template()
     */
    public function newAllocationAction(Request $request) 
    {
        $allocation = new Allocation();
 
        $form = $this->createForm(AllocationType::class, $allocation);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em = $this->getDoctrine()->getManager();
 
            $em->persist($allocation);
 
            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }

    /**
     * @Route("/apartment/add", name="new_apartment")
     * @Template()
     */
    public function newApartmentAction(Request $request) 
    { 
        $apartment = new Apartment();
 
        $form = $this->createForm(ApartmentType::class, $apartment);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em = $this->getDoctrine()->getManager();
 
            $em->persist($apartment);
 
            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }
 
    /**
     * @Route("/tenant/edit/{tenant}", name="edit_tenant")
     * @Template()
     */
    public function editTenantAction(Request $request, $tenant) 
    {
    	$em = $this->getDoctrine()->getManager();
 
    	$repository = $em->getRepository('DHLGSVBundle:Tenant');
 
    	$tenants = $repository->findOneById($tenant);
 
    	if(!$tenants) 
        {    	
    		return $this->redirectToRoute('home');
    	}
 
    	$form = $this->createForm(TenantType::class, $tenants);
 
    	$form->handleRequest($request);
 
    	if ($form->isSubmitted() && $form->isValid()) 
        { 
    		$em->persist($tenants);
 
    		$em->flush();
 
    		return $this->redirectToRoute('home');
    	}
 
    	return array('form' => $form->createView(), 'tenant' => $tenant);
    }

    /**
     * @Route("/house/edit/{house}", name="edit_house")
     * @Template()
     */
    public function editHouseAction(Request $request, $house) 
    { 
        // Get EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Get House repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Search House based on submitted ID
        $houses = $repository->findOneById($house);
 
        // Redirect to startpage if House doesn't exist
        if(!$houses) 
        {     
            return $this->redirectToRoute('home');
        }
 
        // Create new Form based on HouseType
        // and found House
        $form = $this->createForm(HouseType::class, $houses);
 
        // Handle Request (if form is sent)
        $form->handleRequest($request);
 
        // if form is sent and data is valid ...
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            // Pass House to EntityManager
            $em->persist($houses);
 
            // Refresh House data on database
            $em->flush();
 
            // Redirect to startpage
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'house' => $house);
    }

    /**
     * @Route("/apartment/edit/{apartment}", name="edit_apartment")
     * @Template()
     */
    public function editApartmentAction(Request $request, $apartment) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Apartment');
 
        $apartments = $repository->findOneById($apartment);
 
        if(!$apartments) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $form = $this->createForm(ApartmentType::class, $apartments);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em->persist($apartments);
 
            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'apartment' => $apartment);
    }

    /**
     * @Route("/allocation/edit/{allocation}", name="edit_allocation")
     * @Template()
     */
    public function editAllocationAction(Request $request, $allocation) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Allocation');
 
        $allocations = $repository->findOneById($allocation);
 
        if(!$allocations) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $form = $this->createForm(AllocationType::class, $allocations);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em->persist($allocations);

            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'allocation' => $allocation);
    }

    /**
     * @Route("/house/delete/{house}", name="delete_house")
     * @Template()
     */
    public function deleteHouseAction($house) 
    { 
        // Get EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Get House repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Search House based on submitted house ID
        $houses = $repository->findOneById($house);
 
        // Redirect to startpage if House doesn't exist
        if(!$houses) 
        {     
            return $this->redirectToRoute('home');
        }

        // Get Apartment repository and search Apartments based on submitted house ID
        $apartments = $em->getRepository(Apartment::class)->findBy(array('house' => $house));
        
        // Get Allocation repository and search Allocations based on submitted apartment IDs
        $allocations = $em->getRepository(Allocation::class)->findBy(array('apartment' => $apartments));

        foreach ($allocations as $allocation) 
        {   
            // Create Form based on AllocationType and $allocation data
            $form = $this->createForm(AllocationType::class, $allocation);        
     
            // Delete allocation from clipboard
            $em->remove($allocation);
    
            // Refresh allocation on database
            $em->flush();
        }

        foreach ($apartments as $apartment) 
        {
            // Create Form based on ApartmentType and $apartment data
            $form = $this->createForm(ApartmentType::class, $apartment);        
     
            // Delete apartment from clipboard
            $em->remove($apartment);
    
            // Refresh apartment on database
            $em->flush();
        }

        // Create Form based on HouseType and $houses data
        $form = $this->createForm(HouseType::class, $houses);        
 
        // Delete house from clipboard
        $em->remove($houses);
 
        // Refresh house on database
        $em->flush();
 
        // Redirect to startpage
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/apartment/delete/{apartment}", name="delete_apartment")
     * @Template()
     */
    public function deleteApartmentAction($apartment) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Apartment');
 
        $apartments = $repository->findOneById($apartment);
 
        if(!$apartments) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $allocations = $em->getRepository(Allocation::class)->findBy(array('apartment' => $apartment));

        foreach ($allocations as $allocation) 
        {
            $form = $this->createForm(AllocationType::class, $allocation);        
     
            $em->remove($allocation);
     
            $em->flush();
        }

        $form = $this->createForm(ApartmentType::class, $apartments);        
 
        $em->remove($apartments);
 
        $em->flush();
 
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/allocation/delete/{allocation}", name="delete_allocation")
     * @Template()
     */
    public function deleteAllocationAction($allocation) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Allocation');
 
        $allocations = $repository->findOneById($allocation);
 
        if(!$allocations) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $form = $this->createForm(AllocationType::class, $allocations);        
 
        $em->remove($allocations);
 
        $em->flush();
 
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/tenant/delete/{tenant}", name="delete_tenant")
     * @Template()
     */
    public function deleteTenantAction($tenant) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Tenant');
 
        $tenants = $repository->findOneById($tenant);
 
        if(!$tenants) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $allocations = $em->getRepository(Allocation::class)->findBy(array('tenant' => $tenant));

        foreach ($allocations as $allocation) 
        {
            $form = $this->createForm(AllocationType::class, $allocation);        
     
            $em->remove($allocation);
     
            $em->flush();
        }

        $form = $this->createForm(TenantType::class, $tenants);        
 
        $em->remove($tenants);
 
        $em->flush();
 
        return $this->redirectToRoute('home');    
    }    
}
