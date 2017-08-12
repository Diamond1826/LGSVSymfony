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

class MieterController extends Controller
{
	 /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:Mieter');
    	$mieters = $em->findAll();

        $emH = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:House');
        $houses = $emH->findAll();
 
        return array('mieters' => $mieters, 'houses' => $houses);
    }

	 /**
     * @Route("/mieter/add", name="new_mieter")
     * @Template()
     */
    public function newAction(Request $request) {
 
    	// Erstelle "dummy"-Dvd als Referenz
    	$mieter = new Mieter();
 
    	// Erstelle neues Form auf Grundlage des DvdTypes
    	$form = $this->createForm(MieterType::class, $mieter);
 
    	// Verarbeite Request (falls Formular abgesendet wurde)
    	$form->handleRequest($request);
 
    	// Wenn das Formular abgesendet und die Daten gültig sind ...
    	if ($form->isSubmitted() && $form->isValid()) {
 
    		// Hole den EntityManager 
    		$em = $this->getDoctrine()->getManager();
 
    		// Gib die Dvd an den EntityManager
    		$em->persist($mieter);
 
    		// Schreibe Dvd in die Datenbank
    		$em->flush();
 
    		// Und leite auf die Startseite weiter
    		return $this->redirectToRoute('home');
    	}
 
    	return array('form' => $form->createView());
    }

    /**
     * @Route("/house/add", name="new_house")
     * @Template()
     */
    public function newHouseAction(Request $request) {
 
        // Erstelle "dummy"-Dvd als Referenz
        $house = new House();
 
        // Erstelle neues Form auf Grundlage des DvdTypes
        $form = $this->createForm(HouseType::class, $house);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Hole den EntityManager 
            $em = $this->getDoctrine()->getManager();
 
            // Gib die Dvd an den EntityManager
            $em->persist($house);
 
            // Schreibe Dvd in die Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }
 
    /**
     * @Route("/mieter/edit/{mieter}", name="edit_mieter")
     * @Template()
     */
    public function editAction(Request $request, $mieter) {
 
    	// Hole den EntityManager
    	$em = $this->getDoctrine()->getManager();
 
    	// Hole das DVD Repository
    	$repository = $em->getRepository('DHLGSVBundle:Mieter');
 
    	// Suche die DVD anhand der übergebenen ID
    	$mieters = $repository->findOneById($mieter);
 
    	// Leite auf Startseite wenn die DVD nicht existiert
    	if(!$mieters) {    	
    		return $this->redirectToRoute('home');
    	}
 
    	// Erstelle neues Form auf Grundlage des DvdTypes
    	// Und der gefundenen DVD
    	$form = $this->createForm(MieterType::class, $mieters);
 
    	// Verarbeite Request (falls Formular abgesendet wurde)
    	$form->handleRequest($request);
 
    	// Wenn das Formular abgesendet und die Daten gültig sind ...
    	if ($form->isSubmitted() && $form->isValid()) {
 
    		// Gib die Dvd an den EntityManager
    		$em->persist($mieters);
 
    		// Aktualisere Dvd in der Datenbank
    		$em->flush();
 
    		// Und leite auf die Startseite weiter
    		return $this->redirectToRoute('home');
    	}
 
    	return array('form' => $form->createView(), 'mieter' => $mieter);
    }

    /**
     * @Route("/house/edit/{house}", name="edit_house")
     * @Template()
     */
    public function editHouseAction(Request $request, $house) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das DVD Repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Suche die DVD anhand der übergebenen ID
        $houses = $repository->findOneById($house);
 
        // Leite auf Startseite wenn die DVD nicht existiert
        if(!$houses) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des DvdTypes
        // Und der gefundenen DVD
        $form = $this->createForm(HouseType::class, $houses);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Gib die Dvd an den EntityManager
            $em->persist($houses);
 
            // Aktualisere Dvd in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'house' => $house);
    }

    /**
     * @Route("/house/delete/{house}", name="delete_house")
     * @Template()
     */
    public function deleteHouseAction($house) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das DVD Repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Suche die DVD anhand der übergebenen ID
        $houses = $repository->findOneById($house);
 
        // Leite auf Startseite wenn die DVD nicht existiert
        if(!$houses) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des DvdTypes
        // Und der gefundenen DVD
        $form = $this->createForm(HouseType::class, $houses);        
 
            // Gib die Dvd an den EntityManager
            $em->remove($houses);
 
            // Aktualisere Dvd in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mieter/delete/{mieter}", name="delete_mieter")
     * @Template()
     */
    public function deleteAction($mieter) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das DVD Repository
        $repository = $em->getRepository('DHLGSVBundle:Mieter');
 
        // Suche die DVD anhand der übergebenen ID
        $mieters = $repository->findOneById($mieter);
 
        // Leite auf Startseite wenn die DVD nicht existiert
        if(!$mieters) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des DvdTypes
        // Und der gefundenen DVD
        $form = $this->createForm(MieterType::class, $mieters);        
 
            // Gib die Dvd an den EntityManager
            $em->remove($mieters);
 
            // Aktualisere Dvd in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
    }    
}
