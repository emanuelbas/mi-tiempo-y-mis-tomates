<?php

namespace App\Controller;

use App\Form\AccountConfigurationType;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\DBALException;


class AccountConfigurationController extends AbstractController
{
    /**
     * @Route("/account configuration", name="account_configuration")
     */
    public function configure(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $client = $this->get('security.token_storage')->getToken()->getUser(); 
        $form = $this->createForm(AccountConfigurationType::class, $client);
        $error = false;
        $errorMessage = '';

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($client, $client->getPassword());
                $client->setPassword($password);

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($client);
                $entityManager->flush();

            } catch (UniqueConstraintViolationException $e) {
                $error = true;
                $errorMessage = $e->getMessage();
            } catch (DBALException $e) {
                $error = true;
                $errorMessage = 'Se produjo un error al intentar actualizar los datos';
            }

            if ($error) {
                return $this->render(
                    'account_configuration/index.html.twig', //Llama a la vista 
                    array(
                        'form' => $form->createView(),
                        'error' => $errorMessage)
                );
            } else {
                $this->addFlash(
                    'success',
                    'Los datos de su cuenta han sido actualizados correctamente.'
                );
                return $this->redirectToRoute('my_tasks'); //Colocar a donde redireccionar
            }
        }

        return $this->render(
            'account_configuration/index.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $errorMessage)
        );
    }
}