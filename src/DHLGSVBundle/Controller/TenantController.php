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
        // Erstelle "dummy"-House als Referenz
        $house = new House();
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        $form = $this->createForm(HouseType::class, $house);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            // Hole den EntityManager 
            $em = $this->getDoctrine()->getManager();
 
            // Gib das House an den EntityManager
            $em->persist($house);
 
            // Schreibe House in die Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
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
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Suche das House anhand der übergebenen ID
        $houses = $repository->findOneById($house);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$houses) 
        {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(HouseType::class, $houses);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            // Gib das House an den EntityManager
            $em->persist($houses);
 
            // Aktualisere House in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
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
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Suche das House anhand der übergebenen ID
        $houses = $repository->findOneById($house);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$houses) 
        {     
            return $this->redirectToRoute('home');
        }
        
        $apartments = $em->getRepository(Apartment::class)->findBy(array('house' => $house));

        $allocations = $em->getRepository(Allocation::class)->findBy(array('apartment' => $apartments));

        foreach ($allocations as $allocation) 
        {
            $form = $this->createForm(AllocationType::class, $allocation);        
     
            // Lösche mietertowohnung
            $em->remove($allocation);
    
            // Aktualisere mietertowohnung in der Datenbank
            $em->flush();
        }

        foreach ($apartments as $apartment) 
        {
            $form = $this->createForm(ApartmentType::class, $apartment);        
     
            // Lösche die wohnung
            $em->remove($apartment);
    
            // Aktualisere Wohnung in der Datenbank
            $em->flush();
        }

        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(HouseType::class, $houses);        
 
        // Lösche das House
        $em->remove($houses);
 
        // Aktualisere House in der Datenbank
        $em->flush();
 
        // Und leite auf die Startseite weiter
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
