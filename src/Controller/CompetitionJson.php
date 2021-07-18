<?php


namespace App\Controller;


use App\Entity\Competition;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;


class CompetitionJson extends AbstractController
{
    /**
     * @Route("/comp", name="res")
     */
    public function AfiAction()
    {
        $tasks = $this->getDoctrine()->getManager()->getRepository(Competition::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/comp/add", name="quadd")
     */
    public function adAction(Request $request,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $comp = new Competition();
        $comp->setNomCompetition($request->get('nom_competition'));
        $rest=substr($request->get('date_debut'), 0, 20);
        $rest1=substr($request->get('date_debut'), 30, 34);
        $res=$rest.$rest1;
        try {
            $date = new \DateTime($res);
            $comp->setDateDebut($date);

        } catch (\Exception $e) {

        }


        $em->persist($comp);
        $em->flush();
        $jsonContent = $Normalizer->normalize($comp,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/comp/del/{id_competition}", name="cvvd")
     */
    public function del(Request $request,NormalizerInterface $Normalizer,$id_competition)
    {
        $em = $this->getDoctrine()->getManager();
        $comp = $em->getRepository(Competition::class)->find($id_competition);
        $em->remove($comp);
        $em->flush();
        $jsonContent = $Normalizer->normalize($comp,'json',['groups'=>'post:read']);
        return new Response("Deleted".json_encode($jsonContent));
    }
    /**
     * @Route("/comp/{id}", name="quf")
     */
    public function find(Request $request,NormalizerInterface $Normalizer,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $cv = $em->getRepository(Competition::class)->find($id);
        $jsonContent = $Normalizer->normalize($cv,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/comp/modify/{id_competition}", name="cvre")
     */
    public function ModifyAction(Request $request,NormalizerInterface $Normalizer,$id_competition)
    {
        $em = $this->getDoctrine()->getManager();
        $comp = $em->getRepository(Competition::class)->find($id_competition);
        $comp->setNomCompetition($request->get('nom_competition'));
        $rest=substr($request->get('date_debut'), 0, 20);
        $rest1=substr($request->get('date_debut'), 30, 34);
        $res=$rest.$rest1;
        try {
            $date = new \DateTime($res);
            $comp->setDateDebut($date);

        } catch (\Exception $e) {

        }
        $em->flush();
        $jsonContent = $Normalizer->normalize($comp,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
}
