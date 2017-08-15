<?php

namespace DHLGSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DHLGSVBundle\Entity\Mieter;
use DHLGSVBundle\Form\MieterType;
use DHLGSVBundle\Entity\House;
use DHLGSVBundle\Form\HouseType;
use DHLGSVBundle\Entity\Wohnung;
use DHLGSVBundle\Form\WohnungType;
use DHLGSVBundle\Entity\MieterToWohnung;
use DHLGSVBundle\Form\MieterToWohnungType;

class MieterController extends Controller
{
	 /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$mieters = $em->getRepository('DHLGSVBundle:Mieter')->findAll();

        $houses = $em->getRepository('DHLGSVBundle:House')->findAll();

        $wohnungen = $em->getRepository('DHLGSVBundle:Wohnung')->findAll();

        $mietertowohnungen = $em->getRepository('DHLGSVBundle:MieterToWohnung')->findAll();
 
        return array('mieters' => $mieters, 'houses' => $houses, 'wohnungen' => $wohnungen, 'mietertowohnungen' => $mietertowohnungen);
    }

    /**
     * @Route("/wohnungen/view/{house}", name="view_wohnungen")
     * @Template()
     */
    public function viewWohnungenAction($house)
    {
        $em = $this->getDoctrine()->getManager();
        
        $wohnungen = $em->getRepository(Wohnung::class)->findBy(array('house' => $house));

        $mietertowohnungen = $em->getRepository('DHLGSVBundle:MieterToWohnung')->findBy(array('wohnung' => $wohnungen));
 
        return array('wohnungen' => $wohnungen, 'mietertowohnungen' => $mietertowohnungen);
    }

    /**
     * @Route("/wohnungenmieter/view/{mieter}", name="view_wohnungenmieter")
     * @Template()
     */
    public function viewWohnungenMieterAction($mieter)
    {
        $em = $this->getDoctrine()->getManager();

        $mieters = $em->getRepository('DHLGSVBundle:Mieter')->findOneById($mieter);
 
        return array('mieters' => $mieters);
    }

	 /**
     * @Route("/mieter/add", name="new_mieter")
     * @Template()
     */
    public function newAction(Request $request) 
    { 
    	$mieter = new Mieter();
 
    	$form = $this->createForm(MieterType::class, $mieter);
 
    	$form->handleRequest($request);
 
    	if ($form->isSubmitted() && $form->isValid()) 
        { 
    		$em = $this->getDoctrine()->getManager();
 
    		$em->persist($mieter);
 
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
     * @Route("/mietertowohnung/add", name="new_mietertowohnung")
     * @Template()
     */
    public function newMieterToWohnungAction(Request $request) 
    {
        $mietertowohnung = new MieterToWohnung();
 
        $form = $this->createForm(MieterToWohnungType::class, $mietertowohnung);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em = $this->getDoctrine()->getManager();
 
            $em->persist($mietertowohnung);
 
            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }

    /**
     * @Route("/wohnung/add", name="new_wohnung")
     * @Template()
     */
    public function newWohnungAction(Request $request) 
    { 
        $wohnung = new Wohnung();
 
        $form = $this->createForm(WohnungType::class, $wohnung);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em = $this->getDoctrine()->getManager();
 
            $em->persist($wohnung);
 
            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }
 
    /**
     * @Route("/mieter/edit/{mieter}", name="edit_mieter")
     * @Template()
     */
    public function editAction(Request $request, $mieter) 
    {
    	$em = $this->getDoctrine()->getManager();
 
    	$repository = $em->getRepository('DHLGSVBundle:Mieter');
 
    	$mieters = $repository->findOneById($mieter);
 
    	if(!$mieters) 
        {    	
    		return $this->redirectToRoute('home');
    	}
 
    	$form = $this->createForm(MieterType::class, $mieters);
 
    	$form->handleRequest($request);
 
    	if ($form->isSubmitted() && $form->isValid()) 
        { 
    		$em->persist($mieters);
 
    		$em->flush();
 
    		return $this->redirectToRoute('home');
    	}
 
    	return array('form' => $form->createView(), 'mieter' => $mieter);
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
     * @Route("/wohnung/edit/{wohnung}", name="edit_wohnung")
     * @Template()
     */
    public function editWohnungAction(Request $request, $wohnung) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Wohnung');
 
        $wohnungen = $repository->findOneById($wohnung);
 
        if(!$wohnungen) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $form = $this->createForm(WohnungType::class, $wohnungen);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em->persist($wohnungen);
 
            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'wohnung' => $wohnung);
    }

    /**
     * @Route("/mietertowohnung/edit/{mietertowohnung}", name="edit_mietertowohnung")
     * @Template()
     */
    public function editMieterToWohnungAction(Request $request, $mietertowohnung) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:MieterToWohnung');
 
        $mietertowohnungen = $repository->findOneById($mietertowohnung);
 
        if(!$mietertowohnungen) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $form = $this->createForm(MieterToWohnungType::class, $mietertowohnungen);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $em->persist($mietertowohnungen);

            $em->flush();
 
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'mietertowohnung' => $mietertowohnung);
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
        
        $wohnungen = $em->getRepository(Wohnung::class)->findBy(array('house' => $house));

        $mietertowohnungen = $em->getRepository(MieterToWohnung::class)->findBy(array('wohnung' => $wohnungen));

        foreach ($mietertowohnungen as $mietertowohnung) 
        {
            $form = $this->createForm(MieterToWohnungType::class, $mietertowohnung);        
     
            // Lösche mietertowohnung
            $em->remove($mietertowohnung);
    
            // Aktualisere mietertowohnung in der Datenbank
            $em->flush();
        }

        foreach ($wohnungen as $wohnung) 
        {
            $form = $this->createForm(WohnungType::class, $wohnung);        
     
            // Lösche die wohnung
            $em->remove($wohnung);
    
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
     * @Route("/wohnung/delete/{wohnung}", name="delete_wohnung")
     * @Template()
     */
    public function deleteWohnungAction($wohnung) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Wohnung');
 
        $wohnungen = $repository->findOneById($wohnung);
 
        if(!$wohnungen) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $mietertowohnungen = $em->getRepository(MieterToWohnung::class)->findBy(array('wohnung' => $wohnung));

        foreach ($mietertowohnungen as $mietertowohnung) 
        {
            $form = $this->createForm(MieterToWohnungType::class, $mietertowohnung);        
     
            $em->remove($mietertowohnung);
     
            $em->flush();
        }

        $form = $this->createForm(WohnungType::class, $wohnungen);        
 
        $em->remove($wohnungen);
 
        $em->flush();
 
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mietertowohnung/delete/{mietertowohnung}", name="delete_mietertowohnung")
     * @Template()
     */
    public function deleteMieterToWohnungAction($mietertowohnung) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:MieterToWohnung');
 
        $mietertowohnungen = $repository->findOneById($mietertowohnung);
 
        if(!$mietertowohnungen) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $form = $this->createForm(MieterToWohnungType::class, $mietertowohnungen);        
 
        $em->remove($mietertowohnungen);
 
        $em->flush();
 
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mieter/delete/{mieter}", name="delete_mieter")
     * @Template()
     */
    public function deleteAction($mieter) 
    { 
        $em = $this->getDoctrine()->getManager();
 
        $repository = $em->getRepository('DHLGSVBundle:Mieter');
 
        $mieters = $repository->findOneById($mieter);
 
        if(!$mieters) 
        {     
            return $this->redirectToRoute('home');
        }
 
        $mietertowohnungen = $em->getRepository(MieterToWohnung::class)->findBy(array('mieter' => $mieter));

        foreach ($mietertowohnungen as $mietertowohnung) 
        {
            $form = $this->createForm(MieterToWohnungType::class, $mietertowohnung);        
     
            $em->remove($mietertowohnung);
     
            $em->flush();
        }

        $form = $this->createForm(MieterType::class, $mieters);        
 
        $em->remove($mieters);
 
        $em->flush();
 
        return $this->redirectToRoute('home');    
    }    
}
