<?php

namespace DHLGSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
	/**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {   
        // Get authentication utilities
    	$authenticationUtils = $this->get('security.authentication_utils');

	    // Get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // Last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();
        
        // Return rendered loginpage with the last_username and error data
	    return $this->render('security/login.html.twig', array(
	        'last_username' => $lastUsername,
	        'error'         => $error,
	    ));
    }

    /**
     * @Route("/logout", name="logout")
     * @Template()
     */
    public function logoutAction()
    {
    	return $this->redirectToRoute('home');
    }
}
