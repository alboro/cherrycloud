<?php
/**
 * NextCloud / ownCloud - fractalnote
 *
 * Licensed under the Apache License, Version 2.0
 *
 * @author Alexander Demchenko <a.demchenko@aldem.ru>, <https://github.com/alboro>
 * @copyright Alexander Demchenko 2017
 */
namespace OCA\FractalNote\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCA\FractalNote\Service\NotesStructure;
use OCA\FractalNote\Service\ConflictException;
use OCA\FractalNote\Service\NotFoundException;
use OCA\FractalNote\Service\WebException;
use OCA\FractalNote\Controller\AbstractController;

class NoteController extends AbstractController
{
    /**
     * @NoAdminRequired
     *
     * @param integer $mtime
     * @param integer $parentId
     * @param string  $title
     * @param integer $sequence
     *
     * @return DataResponse
     */
    public function create($mtime, $parentId, $title, $sequence)
    {
        return $this->handleWebErrors(function () use ($mtime, $parentId, $title, $sequence) {
            if (!$this->connector->isConnected()) {
                throw new NotFoundException();
            }
            if ($this->connector->getModifyTime() !== $mtime) {
                throw new ConflictException($title);
            }
            $relation = $this->notesStructure->create($parentId, $title, $sequence);
            return [$this->connector->getModifyTime(), $relation->getNodeId()];
        });
    }

    /**
     * @NoAdminRequired
     *
     * @param integer $mtime
     * @param array   $nodeData
     *
     * @return DataResponse
     */
    public function update($mtime, $nodeData)
    {
        return $this->handleWebErrors(function () use ($mtime, $nodeData) {
            $id = array_key_exists('id', $nodeData) ? (int)$nodeData['id'] : null;
            if (!$id || !$this->connector->isConnected()) {
                throw new NotFoundException();
            }
            if ($this->connector->getModifyTime() !== $mtime) {
                throw new ConflictException();
            }
            $this->notesStructure->update(
                $id,
                array_key_exists('title', $nodeData) ? $nodeData['title'] : null,
                array_key_exists('content', $nodeData) ? $nodeData['content'] : null,
                array_key_exists('newParentId', $nodeData) ? $nodeData['newParentId'] : null,
                array_key_exists('sequence', $nodeData) ? $nodeData['sequence'] : null
            );
            return [$this->connector->getModifyTime()];
        });
    }

    /**
     * @param integer $mtime
     * @param integer $id
     *
     * @return DataResponse
     */
    public function destroy($mtime, $id)
    {
        return $this->handleWebErrors(function () use ($mtime, $id) {
            $id = (int)$id;
            if (!$id || !$this->connector->isConnected()) {
                throw new NotFoundException();
            }
            if ($this->connector->getModifyTime() !== $mtime) {
                throw new ConflictException();
            }
            $this->notesStructure->delete($id);
            return [$this->connector->getModifyTime()];
        });
    }
}
