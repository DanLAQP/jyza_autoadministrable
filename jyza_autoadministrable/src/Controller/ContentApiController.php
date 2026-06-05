<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ContentService;
use Cake\Http\Response;

class ContentApiController extends AppController
{
    protected ContentService $contentService;

    public function initialize(): void
    {
        parent::initialize();
        $this->contentService = new ContentService();
        $this->request->allowMethod(['get', 'options']);
        $this->loadComponent('RequestHandler');
    }

    public function section($slug = null)
    {
        // Add simple CORS headers to allow requests from the Astro dev server
        $corsHeaders = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        ];

        if ($this->request->getMethod() === 'OPTIONS') {
            $res = $this->response->withType('application/json')->withStringBody(json_encode(['ok' => true]));
            foreach ($corsHeaders as $k => $v) {
                $res = $res->withHeader($k, $v);
            }
            return $res->withStatus(200);
        }
        if (!$slug) {
            $res = $this->response->withType('application/json')->withStringBody(json_encode(['error' => 'Missing slug']))->withStatus(400);
            foreach ($corsHeaders as $k => $v) { $res = $res->withHeader($k, $v); }
            return $res;
        }

        $data = $this->contentService->getSectionContent($slug, useCache: false);

        if ($data === null) {
            $res = $this->response->withType('application/json')->withStringBody(json_encode(['error' => 'Section not found']))->withStatus(404);
            foreach ($corsHeaders as $k => $v) { $res = $res->withHeader($k, $v); }
            return $res;
        }

        $res = $this->response->withType('application/json')->withStringBody(json_encode($data));
        foreach ($corsHeaders as $k => $v) { $res = $res->withHeader($k, $v); }
        return $res;
    }
}
