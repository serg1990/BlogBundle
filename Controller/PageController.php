<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Blogger\BlogBundle\Form\EnquiryMenu;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
                   ->getManager();

        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
                    ->getLatestBlogs();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    public function contactAction()
    {
                $enquiry = new Enquiry();
            $form = $this->createForm(new EnquiryType(), $enquiry);

            $request = $this->getRequest();
            if ($request->getMethod() == 'POST') {
                $form->bind($request);

                if ($form->isValid()) {
                    // Выполнение некоторого действия, например, отправка письма.

                    // Редирект - это важно для предотвращения повторного ввода данных в форму,
                    // если пользователь обновил страницу.
                    return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
                }
            }

            return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
                'form' => $form->createView()
            ));
    }
    
    
    public function adminAction()
    {
                $enquiry = new Enquiry();
            $form = $this->createForm(new EnquiryMenu(), $enquiry);
            
             $em = $this->getDoctrine()
                   ->getManager();

            $request = $this->getRequest();
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                
                $formname = $request->get("formname");
                if($formname == 'del')
                {
                    $id = $request->get("id");
                    
                    $sql = "DELETE FROM `menu` WHERE id = '".$id."'";
                    $em->getConnection()->query($sql);
                    
                }
                if($formname == 'change')
                {
                    $id = $request->get("id");
                    $name = $request->get("name");
                    $value = $request->get("value");
                    
                    if($name == 'acvtive' AND $value == 'true')
                    {
                        $value = 1;
                    }
                    
                    $sql = "UPDATE `menu` SET `$name`='$value' WHERE id = '".$id."'";
                    $em->getConnection()->query($sql);
                    
                }
               

                if ($form->isValid()) {
                    
                    
                    $name = $request->get("name");
                    $href = $request->get("href");
                     $acvtive = $request->get("acvtive");
                    if($acvtive){
                         $acvtive = 1;
                    }
                    else
                    {
                         $acvtive = 0;
                    }
                   
                    
                    $position = $request->get("position");
                    
                    $sql = " INSERT INTO `menu`(`name`, `href`, `acvtive`, `position`) VALUES ('$name','$href','$acvtive','$position') ";
                    $em->getConnection()->query($sql);
                    return $this->redirect($this->generateUrl('BloggerBlogBundle_admin'));
                }
            }
            
            
            
           
      
                $sql = " SELECT *  FROM menu ORDER BY position ";
                $query = $em->getConnection()->query($sql);

                $menu= $query->fetchAll();
            

            return $this->render('BloggerBlogBundle:Page:admin.html.twig', array(
                'form' => $form->createView(),
                'menus'=>  $menu
        ));
    }
    
    
    public function menuAction($position)
        {
           $em = $this->getDoctrine()
                   ->getManager();
      
        $sql = " SELECT *  FROM menu WHERE position = '".$position."'";
        $query = $em->getConnection()->query($sql);
 
        $menu= $query->fetchAll();

            return $this->render('BloggerBlogBundle:Page:menu.html.twig', array(
                'menus' => $menu
            ));
        }
    
}
