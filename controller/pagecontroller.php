<?php

/**
 * NextCloud / ownCloud - notehierarchy
 *
 * Licensed under the Apache License, Version 2.0
 *
 * @author    Alexander Demchenko <a.demchenko@aldem.ru>, <https://github.com/alboro>
 * @copyright Alexander Demchenko 2017
 */

namespace OCA\NoteHierarchy\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Http\TemplateResponse;
use OCA\NoteHierarchy\Service\NotesStructure;
use OCA\NoteHierarchy\Controller\AbstractController;
use OCA\NoteHierarchy\AppInfo\Application;

class PageController extends AbstractController
{

    /**
     * CAUTION: the @Stuff turns off security checks; for this page no admin is
     *          required and no CSRF check. If you don't know what CSRF is, read
     *          it up in the docs or you might create a security hole. This is
     *          basically the only required method to add this exemption, don't
     *          add it to any other method if you don't exactly know what it does
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index()
    {
        if (!$this->connector->isConnected()) {
            return new TemplateResponse(Application::APP_NAME, '404');
        }
        // Override default CSP
        $csp = new ContentSecurityPolicy();
        $csp->addAllowedChildSrcDomain('blob:');

        $params = [
            'tree'  => $this->notesStructure->buildTree(),
            'mtime' => $this->connector->getModifyTime(),
        ];
        $response = new TemplateResponse(Application::APP_NAME, 'main', $params); // templates/main.php
        $response->setContentSecurityPolicy($csp);
        return $response;
    }
}
