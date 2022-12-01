<?php

use DI\Container;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\ContentLengthMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container;

$container->set('charities', function(): array {
    $asrcDescription = <<<EOF
[The Asylum Seeker Resource Centre (ASRC)](https://asrc.org.au) is Australia's largest human rights organisation providing support to people seeking asylum.

They are an independent not-for-profit organisation whose programs support and empower people seeking asylum to maximise their own physical, mental and social well-being.

They champion the rights of people seeking asylum and mobilise a community of compassion to create lasting social and policy change.
EOF;

    $mjfDescription = <<<EOF
[The Michael J. Fox Foundation for Parkinson's Research](https://www.michaeljfox.org/) exists for one reason: to accelerate the next generation of Parkinson’s disease (PD) treatments.

In practice, that means identifying and funding projects most vital to patients; spearheading solutions around seemingly intractable field-wide challenges; coordinating and streamlining the efforts of multiple, often disparate, teams; and doing whatever it takes to drive faster knowledge turns for the benefit of every life touched by PD.
EOF;

    $mecfsDescription = <<<EOF
[The ME-CFS Portal](https://www.me-cfs.net/) is the largest self-help group in German-speaking countries for people with [Myalgic Encephalomyelitis / Chronic Fatigue Syndrome (ME/CFS)](https://www.nhs.uk/conditions/chronic-fatigue-syndrome-cfs/) and [Long-COVID](https://www.cdc.gov/coronavirus/2019-ncov/long-term-effects/index.html).

The ME-CFS Portal provides comprehensive information and support to people with ME/CF, those who suspect that they may have it, and those wanting to know more about it.

Have you been diagnosed with ME/CF or think that you may suffer from it but don't know what to do? Do you know someone with ME/CF and want to learn more about it? The ME-CFS Portal is the resource you need!
EOF;

    $pcrfDescription = <<<EOF
The core mission of [the Australian Pancreatic Cancer Foundation (PanKind)](https://pankind.org.au/) as a cancer support in Australia is to improve the survival rates and quality of life for pancreatic cancer patients and their families.

It takes a strategic and collaborative approach to addressing the challenges of pancreatic cancer. We focus on raising awareness, providing support and investing in ground-breaking research.
EOF;

    $rrDescription = <<<EOF
[Reuben's Retreat](https://www.reubensretreat.org/) walks side-by-side, offering emotional and practical help through family support charity to families of child loss or those that have a child who is complexly poorly and may face an uncertain future.

It enables families to create memories cocooned in the sanctuary of Reuben’s Retreat underpinned by their army of love and compassionate hearts.
EOF;

$tbbDescription = <<<EOF
[The Birthday Bank](https://thebirthdaybank.org.uk/) provides you with a birthday celebration pack, containing gifts, a cake, and the other essentials that you need to celebrate your child’s special day, such as cards, wrap, candles, decorations and the all-important badge! They show families in need that they are supported and valued by friends in their community
EOF;

    return [
        'asrc' => [
            'image' => 'asrc-background.jpg',
            'name' => 'The Asylum Seeker Resource Center',
            'description' => $asrcDescription,
            'actions' => [
                'Legal aid to those in refugee detention',
                'Advocacy to people in onshore and offshore detention',
                'Train young advocates to tell their stories',
                'Education and training including english language skills and training and professional development courses',
                'Employment programs which build skills, confidence and agency',
                'Paid internships for people seeking asylum who want to develop skills in program evaluation',
        	],
            'email' => 'admin@asrc.org.au',
            'website' => 'https://asrc.org.au',
            'donation_link' => 'https://donate.asrc.org.au/noonebehind',
            'social' => [
                'instagram' => 'asrc1',
                'linkedin' => 'company/asylum-seeker-resource-centre',
                'twitter' => 'ASRC1',
            ]
        ],
        'mjfpr' => [
            'image' => 'michael-j-fox.jpg',
            'name' => "The Michael J. Fox Foundation",
            'description' => $mjfDescription,
            'email' => 'info@michaeljfox.org',
            'website' => 'https://www.michaeljfox.org/',
            'donation_link' => 'https://give.michaeljfox.org/give/421686/#!/donation/checkout',
            'actions' => [
                "Build improved knowledge about the lived experience of Parkinson's disease",
                "Find an objective test for Parkinson's",
                "Engage patients in research",
                "Support the development of new treatments and a cure",
            ],
            'social' => [
                'instagram' => 'michaeljfoxorg',
                'linkedin' => 'company/michaeljfoxorg',
                'twitter' => 'MichaelJFoxOrg',
            ]
        ],
        'mecfs' => [
            'image' => 'me-cfs-portal.jpg',
            'name' => 'ME-CFS Portal (German)',
            'description' => $mecfsDescription,
            'email' => 'program_inquiries@newyork.msf.org',
            'website' => 'https://www.me-cfs.net/',
            'donation_link' => '',
            'actions' => [
                "Provides details about symptoms, diagnosis, important research, available therapies",
                "Support when dealing with government agencies and departments",
                "A forum to talk with, support, and receive support from others",
                "A regularly updated blog on everything related to ME/CF",
                "A database of knowledge about ME/CF as shared by others"
            ],
            'social' => [
                'instagram' => 'me_cfs_portal',
                'twitter' => 'MECFS_Portal',
                'youtube' => 'UCRhCLjPGVo1ZlpsU94xu-8g'
            ]
        ],
        'pcrf' => [
            'image' => 'pancreatic-cancer-foundation.jpg',
            'name' => 'The Australian Pancreatic Cancer Research Foundation',
            'description' => $pcrfDescription,
            'email' => ' info@pankind.org.au',
            'website' => 'https://pankind.org.au/',
            'donation_link' => 'https://pankind.org.au/donate/',
            'actions' => [
                "Invest in research to accelerate treatments and improve survival",
                "Advocate on behalf of the pancreatic cancer community for equitable optimal and earlier access to diagnosis, treatment, and care",
                "Increase awareness of pancreatic cancer to support earlier diagnosis, and raise funds for research",
                "Support patients and carers through comprehensive information, resources, and links to support services"
            ],
            'social' => [
                'instagram' => 'pankind_apcf',
                'twitter' => 'PanKind_APCF',
            ]
        ],
        'rr' => [
            'image' => 'ruebens-retreat.jpg',
            'name' => "Reuben's Retreat",
            'description' => $rrDescription,
            'email' => 'contact@reubensretreat.org',
            'website' => 'https://www.reubensretreat.org/',
            'donation_link' => 'https://www.reubensretreat.org/get-involved/donate/',
            'actions' => [
                "Provide practical and emotional support and promise to walk side by side with a family on their journey",
                "Deliver a bespoke and tailor-made support package for each family and guidance to help them navigate their journey",
                "Peer groups which enable parents of loss to come together, share their story and gain peer support",
                "Counselling and talking therapies can help families to navigate the raw and painful emotions",
            ],
            'social' => [
                'instagram' => 'reubensretreat',
                'linkedin' => 'company/3342334',
                'twitter' => 'ReubensRetreat',
            ]
        ],
        'tbb' => [
            'image' => 'the-birthday-bank.jpg',
            'name' => 'The Birthday Bank',
            'description' => $tbbDescription,
            'email' => 'laura@thebirthdaybank.org.uk',
            'website' => 'https://thebirthdaybank.org.uk/',
            'donation_link' => 'https://thebirthdaybank.org.uk/#features',
            'social' => [
                   'instagram' => 'thebirthdaybank',
                'linkedin' => 'in/lauracunningham3',
            ]
        ],
    ];
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/charities', function (Request $request, Response $response, array $args): Response {
    return new JsonResponse(
        $this->get('charities'), 
        200, 
        ['Access-Control-Allow-Origin' => '*']
    );
})->add(new ContentLengthMiddleware());

$app->run();
