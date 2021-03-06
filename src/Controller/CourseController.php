<?php
/**
 * Created by PhpStorm.
 * User: grantas
 * Date: 18.3.30
 * Time: 13.59
 */

namespace App\Controller;
use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class CourseController extends Controller
{

    /**
     * @Route("api/courses", name="api_course_create", methods="POST")
     */
    public function setCourse(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $data = json_decode($request->getContent(), true);
        $form->submit($data, false);

        if($form->isSubmitted() && $form->isValid()){
            $course->setCreationDate();
        }
        else{
            $errors = array();

            foreach ($form as $child) {
                if (!$child->isValid()) {
                    foreach($child->getErrors() as $error)
                    $errors[$child->getName()] = $error->getMessage();
                }
            }

            return new JsonResponse([
                 'error_message' => $errors
             ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();
        }
        catch (\Exception $e) {
            return new JsonResponse([
                     'error_message' => $e,
               ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse([
            'success_message' => 'Successfully created new course'
        ], Response::HTTP_CREATED);

    }

    /**
     * @Route("api/courses/{id}", name="api_course_get", methods="GET")
     */
    public function getCourse(int $id)
    {
        $course = null;
        $course = $this->getDoctrine()
            ->getRepository(Course::class)
            ->find($id);

        if (!$course) {
            return new JsonResponse([
                'error_message' => 'No course found for id '. $id
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JSONResponse([
            $course
        ]);
    }

    /**
     * @Route("api/courses/{id}", name="api_course_update", methods="PUT")
     */
    public function editCourse(int $id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository(Course::class)
            ->find($id);

        if (!$course) {
            return new JsonResponse([
                'error_message' => 'No course found for id '. $id
            ], Response::HTTP_BAD_REQUEST);
        }
        $form = $this->createForm(CourseType::class, $course);
        $data = json_decode($request->getContent(), true);
        $form->submit($data, false);

        if(!($form->isSubmitted() && $form->isValid())){
            $errors = array();

            foreach ($form as $child) {
                if (!$child->isValid()) {
                    foreach($child->getErrors() as $error)
                        $errors[$child->getName()] = $error->getMessage();
                }
            }

            return new JsonResponse([
                'error_message' => $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $em->persist($course);
            $em->flush();
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'error_message' => $e,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse([
            'success_message' => 'Successfully updated course '. $id
        ]);
    }

    /**
     * @Route("api/courses", name="api_course_getAll", methods="GET")
     */
    public function getCourses(){
        $courses = $this->getDoctrine()
            ->getRepository(Course::class)
            ->findAll();

        return new JSONResponse(
            $courses
        );
    }
}