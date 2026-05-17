<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Requests Controller (Admin Prefix)
 *
 * @property \App\Model\Table\RequestsTable $Requests
 */
class RequestsController extends AppController
{
    public function request()
    {
        $this->paginate = [
            'contain' => ['Procedures', 'Users'],
        ];
        $conditions = ['Requests.status !=' => 'Draft'];

        if ($this->request->getQuery('search')) {
            $searchTerm = $this->request->getQuery('search');
            $conditions['Users.name LIKE'] = '%' . $searchTerm . '%';
        }

        if ($this->request->getQuery('status')) {
            $status = $this->request->getQuery('status');
            $conditions['Requests.status'] = $status;
        }

        $this->paginate['conditions'] = $conditions;
        $requests = $this->paginate($this->Requests);

        $this->set(compact('requests'));
    }

    public function pending()
    {
        $this->paginate = [
            'contain' => ['Procedures', 'Users'],
        ];
        
        $conditions = ['Requests.status' => 'pending'];

        if ($this->request->getQuery('search')) {
            $searchTerm = $this->request->getQuery('search');
            $conditions['Users.name LIKE'] = '%' . $searchTerm . '%';
        }

        $this->paginate['conditions'] = $conditions;
        $requests = $this->paginate($this->Requests);

        $this->set(compact('requests'));
        $this->render('request');
    }

    public function approudrequest($id)
    {
        $this->request->allowMethod(['post']);

        $request = $this->Requests->get($id, [
            'contain' => ['Requestrequirements']
        ]);

        $requirementstatus = true;
        foreach ($request->requestrequirements as $requestrequirement) {
            if ($requestrequirement->status !== 'success') {
                $requirementstatus = false;
                break;
            }
        }

        if ($requirementstatus) {
            $request->status = 'success';
            if ($this->Requests->save($request)) {
                $this->Flash->success('Requête approuvée avec succès.');
            } else {
                $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
            }
            $this->redirect(['action' => 'firstview', $request->id]);
        } else {
            $this->Flash->error('Certains Requestrequirements ont un statut "pending" ou "rejected".');
            $this->redirect(['action' => 'firstview', $request->id]);
        }
    }

    public function rejectrequest($id)
    {
        $this->request->allowMethod(['post']);

        $request = $this->Requests->get($id);
        $request->status = 'rejected';

        if ($this->Requests->save($request)) {
            $this->Flash->success('Requête rejetée.');
        } else {
            $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
        }

        return $this->redirect(['action' => 'request']);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $request = $this->Requests->find('all', [
            'conditions' => ['id' => $id, 'deleted' => 0],
        ])->first();
        if (empty($request)) {
            $this->Flash->error("request not found");
            $this->redirect($this->referer());
        }
        $request->set('deleted', true);

        if ($this->Requests->save($request)) {
            $this->Flash->success(__('The request has been deleted.'));
        } else {
            $this->Flash->error(__('The request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'request']);
    }

    public function firstview($request_id)
    {
        $request = $this->Requests->get($request_id, [
            'conditions' => ['Requests.deleted' => 0],
            'contain' => ['Users', 'Procedures', 'Requestrequirements' => ['Requestrequirementproprieties' => ['Requirementproprieties'], 'Procedurerequirements' => ['Requirements']]],
        ]);

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect($this->referer());
        }

        $procedurerequirements = $this->Requests->Procedures->Procedurerequirements->find('all', [
            'conditions' => [
                'Procedurerequirements.procedure_id' => $request->procedure_id
            ],
            'contain' => ['Requirements'],
        ])->all();

        $this->set(compact('procedurerequirements', 'request'));
    }
}
