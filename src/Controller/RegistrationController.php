<?php

namespace App\Controller;

use App\Form\ClientType;
use App\Entity\Client;
use App\Entity\PomodorosConfiguration;
use App\Entity\ClientApplicationsConfiguration;
use App\Entity\ClientCategoryConfiguration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\DBALException;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $error = false;
        $errorMessage = '';

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // 3) Encode the password (you could also do this via Doctrine listener)   
                $password = $passwordEncoder->encodePassword($client, $client->getPassword());
                $client->setPassword($password);

                // 4) Add the default configuration for the pomodoros
                $entityManager = $this->getDoctrine()->getManager();

                $pomodorosConfiguration = new PomodorosConfiguration();
                $pomodorosConfiguration->setBreakTime(5);
                $pomodorosConfiguration->setWorkingTime(25);
                $pomodorosConfiguration->setEndBreakAlarm(FALSE);
                $pomodorosConfiguration->setEndWorkAlarm(FALSE);
                $pomodorosConfiguration->setClockSound(TRUE); 
                $pomodorosConfiguration->setClient($client);    
                $client->setPomodorosConfiguration($pomodorosConfiguration);

                // Se levanta del em, las aplicaciones, categorias y niveles para asignar las configuraciones por defecto del usuario
                $productividadBaja = $entityManager->getRepository("App\Entity\ProductivityLevel")->findOneBy(['level_name' => 'Baja']);
                $productividadAlta = $entityManager->getRepository("App\Entity\ProductivityLevel")->findOneBy(['level_name' => 'Alta']);
                $productividadNeutral = $entityManager->getRepository("App\Entity\ProductivityLevel")->findOneBy(['level_name' => 'Neutral']);

                $negocios = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Negocios']);
                $comunicacionYPlanificacion = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Comunicación y planificación']);
                $entretenimientoYRedesSociales = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Entretenimientos y redes sociales']);
                $diseno = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Diseño']);
                $noticias = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Noticias']);
                $desarrolloDeSoftware = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Desarrollo de software']);
                $compras = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Compras']);
                $utilidadReferencias = $entityManager->getRepository("App\Entity\Category")->findOneBy(['category_name' => 'Utilidad, referencias']);

                $applicationS = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Spotify']);
                $applicationG = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Google Chrome']);
                $applicationVS = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Microsoft Visual Studio 2017']);
                $applicationFF = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Mozila Firefox']);
                $applicationBDN = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Bloc de notas']);
                $applicationFF1 = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Firefox']);
                $applicationHB = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'HandBrake']);
                $applicationPST = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'PhpStorm']);
                $applicationVSC = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'Visual Studio Code']);

                $entityManager->persist($client);
                $entityManager->persist($pomodorosConfiguration);  

                //Generando las configuraciones por defecto

                $category = $negocios;
                $productivityLevel = $productividadAlta;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                $category = $comunicacionYPlanificacion;
                $productivityLevel = $productividadNeutral;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                $category = $entretenimientoYRedesSociales;
                $productivityLevel = $productividadBaja;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                $category = $diseno;
                $productivityLevel = $productividadAlta;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                // Aplicaciones de diseño
                $aconfig = new ClientApplicationsConfiguration($client, $applicationHB, $category);
                $entityManager->persist($aconfig);
                $entityManager->flush();

                $category = $noticias;
                $productivityLevel = $productividadBaja;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                $category = $desarrolloDeSoftware;
                $productivityLevel = $productividadAlta;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                // Aplicaciones de desarrollo
                $aconfig = new ClientApplicationsConfiguration($client, $applicationPST, $category);
                $entityManager->persist($aconfig);
                $aconfig = new ClientApplicationsConfiguration($client, $applicationVS, $category);
                $entityManager->persist($aconfig);
                $aconfig = new ClientApplicationsConfiguration($client, $applicationVSC, $category);
                $entityManager->persist($aconfig); 

                $category = $compras;
                $productivityLevel = $productividadBaja;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                $category = $utilidadReferencias;
                $productivityLevel = $productividadNeutral;
                $cconfig = new ClientCategoryConfiguration($client, $category, $productivityLevel);
                $entityManager->persist($cconfig);
                $entityManager->flush();

                // Aplicaciones de utilidad
                $aconfig = new ClientApplicationsConfiguration($client, $applicationG, $category);
                $entityManager->persist($aconfig); 
                $aconfig = new ClientApplicationsConfiguration($client, $applicationFF, $category);
                $entityManager->persist($aconfig); 
                $aconfig = new ClientApplicationsConfiguration($client, $applicationFF1, $category);
                $entityManager->persist($aconfig); 
                $aconfig = new ClientApplicationsConfiguration($client, $applicationBDN, $category);
                $entityManager->persist($aconfig);



                $entityManager->flush();

            } catch (UniqueConstraintViolationException $e) {
                $error = true;
                $errorMessage = $e->getMessage();
            } catch (DBALException $e) {
                $error = true;
                $errorMessage = 'Se produjo un error al intentar crear la cuenta.';
            }

            if ($error) {
                return $this->render(
                    'registration/register.html.twig',
                    array(
                        'form' => $form->createView(),
                        'error' => $errorMessage)
                );
            } else {
                $this->addFlash(
                    'success',
                    'Tu cuenta ha sido creada exitosamente.'
                );
                return $this->redirectToRoute('login');
            }
        }

        return $this->render(
            'registration/register.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $errorMessage)
        );
    }
}