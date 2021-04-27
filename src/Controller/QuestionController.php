<?php

namespace App\Controller;

use App\Service\MarkDownHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;


class QuestionController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $isDebug;

    /**
     * QuestionController constructor.
     * @param LoggerInterface $logger
     * @param bool $isDebug
     */
    public function __construct(LoggerInterface $logger, bool $isDebug) {

        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }


    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Environment $twigEnvironment)
    {
        /*
        // fun example of using the Twig service directly!
        $html = $twigEnvironment->render('question/homepage.html.twig');

        return new Response($html);
        */

        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show($slug, MarkDownHelper $markDownHelper)
    {

        if ($this->isDebug) $this->logger->alert("nooooooo");

        $answers = [
            'Make sure your cat is sitting purrrfectly still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        $questionText = "I've been `turned` into a cat, any thoughts on how to turn back? While I'm adorable, I don't really care for cat food.";

        $parsedQuestion = $markDownHelper->parse($questionText);

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            "questionText" => $parsedQuestion,
            'answers' => $answers,
        ]);
    }
}
