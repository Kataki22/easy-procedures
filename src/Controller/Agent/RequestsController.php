<?php

declare(strict_types=1);

namespace App\Controller\Agent;

use App\Controller\AppController;

/**
 * Requests Controller (Agent Prefix)
 *
 * @property \App\Model\Table\RequestsTable $Requests
 */
class RequestsController extends AppController
{
    public function pending()
    {
        $this->paginate = [
            'contain' => ['Procedures', 'Users'],
            'conditions' => ['Requests.status' => 'pending']
        ];

        $conditions = ['Requests.status' => 'pending'];

        if ($this->request->getQuery('search')) {
            $searchTerm = $this->request->getQuery('search');
            $conditions['Users.name LIKE'] = '%' . $searchTerm . '%';
        }

        $this->paginate['conditions'] = $conditions;
        $requests = $this->paginate($this->Requests);

        $this->set(compact('requests'));
    }

    public function requestapprobation($id)
    {
        $this->request->allowMethod(['post']);

        $request = $this->Requests->get($id, [
            'contain' => ['Procedures', 'Requestrequirements' => ['Procedurerequirements'=>['Requirements']]]
        ]);
       
        $procedureRequirements = $this->Requests->Procedures->Procedurerequirements;
        $requirementStatus = true;

        foreach ($procedureRequirements as $procedureRequirement) {
            $matchingRequirement = $request->Requestrequirements->find()
                ->where(['procedurerequirement_id' => $procedureRequirement->id ])
                ->first();

            if (!$matchingRequirement || $matchingRequirement->status !== 'pending') {
                $requirementStatus = false;
                break;
            }
        }

        if ($requirementStatus) {
            $request->status = 'pending';
            if ($this->Requests->save($request)) {
                $this->Flash->success('Tous les pré-requis ont été remplis avec succès.');
            } else {
                $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
            }
        } else {
            $this->Flash->error('Veuillez remplir tous les pré-requis.');
        }

        return $this->redirect(['action' => 'requirementlist', $request->id]);
    }

    public function cancelapprobation($id)
    {
        $this->request->allowMethod(['post']);

        $request = $this->Requests->get($id);
        $request->status = 'Draft';

        if ($this->Requests->save($request)) {
            $this->Flash->success('Approbation annulée.');
        } else {
            $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
        }
        return $this->redirect(['action' => 'requirementlist', $request->id]);
    }

    public function approuverequirement($id_req_requirement)
    {
        $this->request->allowMethod(['post']);

        $requestrequirement = $this->Requests->Requestrequirements->get($id_req_requirement);
        $requestrequirement->status = 'success';

        if ($this->Requests->Requestrequirements->save($requestrequirement)) {
            $this->Flash->success('Pré-requis approuvé.');
        } else {
            $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
        }

        return $this->redirect(['action' => 'firstview', $requestrequirement->request_id]);
    }

    public function rejectrequirement($id_req_requirement)
    {
        $this->request->allowMethod(['post']);

        $requestrequirement = $this->Requests->Requestrequirements->get($id_req_requirement);
        $requestrequirement->status = 'rejected';

        if ($this->Requests->Requestrequirements->save($requestrequirement)) {
             $this->Flash->success('Pré-requis rejeté.');
        } else {
            $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
        }

        return $this->redirect(['action' => 'raison', $id_req_requirement]);
    }

    public function raison($id_req_requirement = null)
    {
        $requestrequirement = $this->Requests->Requestrequirements->get($id_req_requirement, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestrequirement = $this->Requests->Requestrequirements->patchEntity($requestrequirement, $this->request->getData());
            if ($this->Requests->Requestrequirements->save($requestrequirement)) {
                $this->Flash->success(__('Raison envoyée avec succès au client.'));
                return $this->redirect(['action' => 'firstview', $requestrequirement->request_id]);
            }
            $this->Flash->error(__('Erreur lors de l\'envoi de la raison. Veuillez réessayer.'));
        }
        
        $this->set(compact('requestrequirement'));
    }

    public function firstview($request_id)
    {
        $request = $this->Requests->get($request_id, [
            'conditions' => ['Requests.deleted' => 0],
            'contain' => ['Users', 'Procedures', 'Requestrequirements' => ['Requestrequirementproprieties' => ['Requirementproprieties'], 'Procedurerequirements' => ['Requirements']]],
        ]);

        if (empty($request)) {
            $this->Flash->error("Impossible de charger la demande.");
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

    public function requirementlist($request_id)
    {
        $request = $this->Requests->find('all', [
            'conditions' => ['Requests.id' => $request_id, 'Requests.deleted' => 0],
            'contain' => ['Requestrequirements', 'Procedures'],
        ])->first();

        if (empty($request)) {
            $this->Flash->error("Impossible de charger la demande.");
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
                $this->Flash->success('Demande approuvée avec succès.');
            } else {
                $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
            }
            return $this->redirect(['action' => 'firstview', $request->id]);
        } else {
            $this->Flash->error('Certains pré-requis ont un statut "en attente" ou "rejeté".');
            return $this->redirect(['action' => 'firstview', $request->id]);
        }
    }

    public function rejectrequest($id)
    {
        $this->request->allowMethod(['post']);

        $request = $this->Requests->get($id);
        $request->status = 'rejected';

        if ($this->Requests->save($request)) {
            $this->Flash->success('Demande rejetée.');
        } else {
            $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
        }

        return $this->redirect(['action' => 'pending']);
    }
}
