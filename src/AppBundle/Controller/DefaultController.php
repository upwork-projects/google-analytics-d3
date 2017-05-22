<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {

        $analyticsService = $this->get('google_analytics_api.api');
        $viewId = $this->container->getParameter('google_analytics_view_id');
        $data['sessions'] = $analyticsService->getSessionsDateRange($viewId, '90daysAgo', 'today');
        $data['bounceRate'] = $analyticsService->getBounceRateDateRange($viewId, '90daysAgo', 'today');
        $data['avgTimeOnPage'] = $analyticsService->getAvgTimeOnPageDateRange($viewId, '30daysAgo', 'today');
        $data['pageViewsPerSession'] = $analyticsService->getPageviewsPerSessionDateRange($viewId, '30daysAgo', 'today');
        $data['percentNewVisits'] = $analyticsService->getPercentNewVisitsDateRange($viewId, '30daysAgo', 'today');
        $data['pageViews'] = $analyticsService->getPageViewsDateRange($viewId, '30daysAgo', 'today');
        $data['avgPageLoadTime'] = $analyticsService->getAvgPageLoadTimeDateRange($viewId, '30daysAgo', 'today');

        return $this->render('default/index.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'data' => $data
        ]);
    }

}
