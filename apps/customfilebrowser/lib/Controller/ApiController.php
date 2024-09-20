<?php
namespace OCA\CustomFileBrowser\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\FileDisplayResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\Files\IRootFolder;
use OCP\IUserSession;
use OCP\IURLGenerator;
use OCP\Files\File;
use OCP\Files\NotFoundException;


class ApiController extends Controller {
    private $rootFolder;
    private $userSession;

    public function __construct($AppName, IRequest $request, IRootFolder $rootFolder, IUserSession $userSession, IURLGenerator $urlGenerator) {
        parent::__construct($AppName, $request);
        $this->rootFolder = $rootFolder;
        $this->userSession = $userSession;
        $this->urlGenerator = $urlGenerator;
    }
    

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function getUserFiles() {
        $user = $this->userSession->getUser();
        $userFolder = $this->rootFolder->getUserFolder($user->getUID());
        $files = $this->listFiles($userFolder);

        $response = new DataResponse($files);
        $response->addHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->addHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function optionsUserFiles() {
        $response = new DataResponse(null);
        $response->addHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->addHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $response->addHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-Requested-With');
        $response->addHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }

    private function listFiles($folder) {
        $files = [];
        $userFolderPath = $folder->getPath(); // Get the user's folder path
        foreach ($folder->getDirectoryListing() as $node) {
            if ($node->getType() === 'file') {
                $filePath = $node->getPath(); // Full path of the file
    
                // Compute the relative path by removing the user's folder path
                $relativePath = ltrim(substr($filePath, strlen($userFolderPath)), '/');
    
                // Construct the download URL
                $downloadUrl = $this->urlGenerator->linkToRouteAbsolute('customfilebrowser.api.downloadFile', ['path' => $relativePath]);
    
                $files[] = [
                    'name' => $node->getName(),
                    'path' => $filePath,
                    'size' => $node->getSize(),
                    'type' => $node->getType(),
                    'mimetype' => $node->getMimetype(),
                    'downloadUrl' => $downloadUrl,
                ];
            }
        }
        return $files;
    }
    

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function downloadFile() {
        $path = $this->request->getParam('path');
        if ($path === null) {
            return new JSONResponse(['error' => 'Path parameter is missing'], 400);
        }

        $user = $this->userSession->getUser();
        $userFolder = $this->rootFolder->getUserFolder($user->getUID());

        try {
            $node = $userFolder->get($path);

            if ($node instanceof \OCP\Files\File) {
                $response = new FileDisplayResponse($node);
                $filename = $node->getName();
                $mimeType = $node->getMimetype();

                // Set headers to force download
                $response->addHeader('Content-Type', $mimeType);
                $response->addHeader('Content-Disposition', 'attachment; filename="' . addslashes($filename) . '"');
                $response->addHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
                $response->addHeader('Access-Control-Allow-Credentials', 'true');

                return $response;
            } else {
                return new JSONResponse(['error' => 'The specified path is not a file'], 400);
            }
        } catch (\OCP\Files\NotFoundException $e) {
            return new JSONResponse(['error' => 'File not found'], 404);
        }
    }




    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function optionsDownloadFile() {
        $response = new DataResponse(null);
        $response->addHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->addHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $response->addHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-Requested-With');
        $response->addHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }


    
}
