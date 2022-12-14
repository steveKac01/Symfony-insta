<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * Delete a post then redirect to home with a flash message.
     *
     * @param Image $image
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[route('member/image/delete/{id}', 'image.delete', methods: ['GET'])]
    #[Security("is_granted('ROLE_USER') and user === image.getUserImage()")]
    public function delete(Image $image, EntityManagerInterface $manager): Response
    {
        $manager->remove($image);
        $manager->flush();

        $this->addFlash(
            'success',
            'Your post has been successfully deleted !'
        );

        return $this->redirectToRoute('home');
    }
}
