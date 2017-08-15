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
    	$em = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:Mieter');
    	$mieters = $em->findAll();

        $emH = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:House');
        $houses = $emH->findAll();

        $emW = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:Wohnung');
        $wohnungen = $emW->findAll();

        $emM = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:MieterToWohnung');
        $mietertowohnungen = $emM->findAll();
 
        return array('mieters' => $mieters, 'houses' => $houses, 'wohnungen' => $wohnungen, 'mietertowohnungen' => $mietertowohnungen);
    }

    /**
     * @Route("/wohnungen/view/{house}", name="view_wohnungen")
     * @Template()
     */
    public function viewWohnungenAction($house)
    {
        $emW = $this->getDoctrine()->getManager()->getRepository(Wohnung::class);
        $wohnungen = $emW->findBy(array('house' => $house));

        $emM = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:MieterToWohnung');
        $mietertowohnungen = $emM->findBy(array('wohnung' => $wohnungen));
 
        return array('wohnungen' => $wohnungen, 'mietertowohnungen' => $mietertowohnungen);
    }

    /**
     * @Route("/wohnungenmieter/view/{mieter}", name="view_wohnungenmieter")
     * @Template()
     */
    public function viewWohnungenMieterAction($mieter)
    {
        $emW = $this->getDoctrine()->getManager()->getRepository('DHLGSVBundle:Mieter');
        $mieters = $emW->findOneById($mieter);
 
        return array('mieters' => $mieters);
    }

	 /**
     * @Route("/mieter/add", name="new_mieter")
     * @Template()
     */
    public function newAction(Request $request) {
 
    	// Erstelle "dummy"-Mieter als Referenz
    	$mieter = new Mieter();
 
    	// Erstelle neues Form auf Grundlage des NieterTypes
    	$form = $this->createForm(MieterType::class, $mieter);
 
    	// Verarbeite Request (falls Formular abgesendet wurde)
    	$form->handleRequest($request);
 
    	// Wenn das Formular abgesendet und die Daten gültig sind ...
    	if ($form->isSubmitted() && $form->isValid()) {
 
    		// Hole den EntityManager 
    		$em = $this->getDoctrine()->getManager();
 
    		// Gib den Mieter an den EntityManager
    		$em->persist($mieter);
 
    		// Schreibe Mieter in die Datenbank
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
 
        // Erstelle "dummy"-House als Referenz
        $house = new House();
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        $form = $this->createForm(HouseType::class, $house);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
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
    public function newMieterToWohnungAction(Request $request) {
 
        // Erstelle "dummy"-House als Referenz
        $mietertowohnung = new MieterToWohnung();
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        $form = $this->createForm(MieterToWohnungType::class, $mietertowohnung);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Hole den EntityManager 
            $em = $this->getDoctrine()->getManager();
 
            // Gib das House an den EntityManager
            $em->persist($mietertowohnung);
 
            // Schreibe House in die Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView());
    }

    /**
     * @Route("/wohnung/add", name="new_wohnung")
     * @Template()
     */
    public function newWohnungAction(Request $request) {
 
        // Erstelle "dummy"-House als Referenz
        $wohnung = new Wohnung();
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        $form = $this->createForm(WohnungType::class, $wohnung);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Hole den EntityManager 
            $em = $this->getDoctrine()->getManager();
 
            // Gib das House an den EntityManager
            $em->persist($wohnung);
 
            // Schreibe House in die Datenbank
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
 
    	// Hole das Mieter Repository
    	$repository = $em->getRepository('DHLGSVBundle:Mieter');
 
    	// Suche den Mieter anhand der übergebenen ID
    	$mieters = $repository->findOneById($mieter);
 
    	// Leite auf Startseite wenn der Mieter nicht existiert
    	if(!$mieters) {    	
    		return $this->redirectToRoute('home');
    	}
 
    	// Erstelle neues Form auf Grundlage des MieterTypes
    	// Und des gefundenen Mieters
    	$form = $this->createForm(MieterType::class, $mieters);
 
    	// Verarbeite Request (falls Formular abgesendet wurde)
    	$form->handleRequest($request);
 
    	// Wenn das Formular abgesendet und die Daten gültig sind ...
    	if ($form->isSubmitted() && $form->isValid()) {
 
    		// Gib den Mieter an den EntityManager
    		$em->persist($mieters);
 
    		// Aktualisere Mieter in der Datenbank
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
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Suche das House anhand der übergebenen ID
        $houses = $repository->findOneById($house);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$houses) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(HouseType::class, $houses);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
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
    public function editWohnungAction(Request $request, $wohnung) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:Wohnung');
 
        // Suche das House anhand der übergebenen ID
        $wohnungen = $repository->findOneById($wohnung);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$wohnungen) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(WohnungType::class, $wohnungen);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Gib das House an den EntityManager
            $em->persist($wohnungen);
 
            // Aktualisere House in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'wohnung' => $wohnung);
    }

    /**
     * @Route("/mietertowohnung/edit/{mietertowohnung}", name="edit_mietertowohnung")
     * @Template()
     */
    public function editMieterToWohnungAction(Request $request, $mietertowohnung) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:MieterToWohnung');
 
        // Suche das House anhand der übergebenen ID
        $mietertowohnungen = $repository->findOneById($mietertowohnung);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$mietertowohnungen) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(MieterToWohnungType::class, $mietertowohnungen);
 
        // Verarbeite Request (falls Formular abgesendet wurde)
        $form->handleRequest($request);
 
        // Wenn das Formular abgesendet und die Daten gültig sind ...
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Gib das House an den EntityManager
            $em->persist($mietertowohnungen);
 
            // Aktualisere House in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
        }
 
        return array('form' => $form->createView(), 'mietertowohnung' => $mietertowohnung);
    }

    /**
     * @Route("/house/delete/{house}", name="delete_house")
     * @Template()
     */
    public function deleteHouseAction($house) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:House');
 
        // Suche das House anhand der übergebenen ID
        $houses = $repository->findOneById($house);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$houses) {     
            return $this->redirectToRoute('home');
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
    public function deleteWohnungAction($wohnung) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:Wohnung');
 
        // Suche das House anhand der übergebenen ID
        $wohnungen = $repository->findOneById($wohnung);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$wohnungen) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(WohnungType::class, $wohnungen);        
 
            // Lösche das House
            $em->remove($wohnungen);
 
            // Aktualisere House in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mietertowohnung/delete/{mietertowohnung}", name="delete_mietertowohnung")
     * @Template()
     */
    public function deleteMieterToWohnungAction($mietertowohnung) {
 
        // Hole den EntityManager
        $em = $this->getDoctrine()->getManager();
 
        // Hole das House Repository
        $repository = $em->getRepository('DHLGSVBundle:MieterToWohnung');
 
        // Suche das House anhand der übergebenen ID
        $mietertowohnungen = $repository->findOneById($mietertowohnung);
 
        // Leite auf Startseite wenn das House nicht existiert
        if(!$mietertowohnungen) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des HouseTypes
        // Und des gefundenen Houses
        $form = $this->createForm(MieterToWohnungType::class, $mietertowohnungen);        
 
            // Lösche das House
            $em->remove($mietertowohnungen);
 
            // Aktualisere House in der Datenbank
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
 
        // Hole das Mieter Repository
        $repository = $em->getRepository('DHLGSVBundle:Mieter');
 
        // Suche den Mieter anhand der übergebenen ID
        $mieters = $repository->findOneById($mieter);
 
        // Leite auf Startseite wenn der Mieter nicht existiert
        if(!$mieters) {     
            return $this->redirectToRoute('home');
        }
 
        // Erstelle neues Form auf Grundlage des MieterTypes
        // Und des gefundenen Mieters
        $form = $this->createForm(MieterType::class, $mieters);        
 
            // Lösche den Mieter
            $em->remove($mieters);
 
            // Aktualisere Mieter in der Datenbank
            $em->flush();
 
            // Und leite auf die Startseite weiter
            return $this->redirectToRoute('home');
    }    
}
