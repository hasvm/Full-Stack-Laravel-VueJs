import { defineStore } from "pinia";
import {useWalletStore} from './wallet-store'
import requests from '../candidates/requests/requests';

export const useCandidatesStore = defineStore('candidatesStore', {
    state: () => ({
        candidates: [],
        contactHistory: [],
        wallet: useWalletStore(),
        loading: true,
    }),

    actions: {
        contactStatus(id) {
            let contactHistory = this.contactHistory.find(history => history.candidate_id === id);
            return typeof contactHistory === 'undefined' ? 'Contact' : (contactHistory.contacted ? 'Contacted': 'Contact');
        },
        hireStatus(id) {
            let contactHistory = this.contactHistory.find(history => history.candidate_id === id);
            return typeof contactHistory === 'undefined' ? 'Hire' : (contactHistory.hired ? 'Hired': 'Hire');
        },
        async getCandidates() {
            requests.getCandidates().then(response => {
                this.candidates = response.candidates;
                this.contactHistory = response.contactHistory;
                this.loading = false;
            });
        },
        async contactCandidate(id) {
            let data = {
                'candidateId': id,
            };
            return requests.contactCandidate(data).then(response => {
                if (response.type === 'success') {
                    this.updateCandidateContactStatus(id);
                    this.wallet.contact();
                }
                return response.msg;
            });
        },
        updateCandidateContactStatus(id) {
            this.contactHistory.push( {
                company_id: 1,
                candidate_id: id,
                contacted: true,
                hired: false
            });
        },
        async hireCandidate(id) {
            let data = {
                'candidateId': id,
            };
            return requests.hireCandidate(data).then(response => {
                if (response.type === 'success') {
                    this.updateCandidateHireStatus(id);
                    this.wallet.hire();
                }
                return response.msg;
            });
        },
        updateCandidateHireStatus(id) {
            let contactHistory = this.contactHistory.find(history => history.candidate_id === id);
            contactHistory.hired = true;
        },
    },
});