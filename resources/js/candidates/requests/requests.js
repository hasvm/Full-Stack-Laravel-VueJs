import {fetchPost, fetchGet} from '../../helpers/requests';

// Requests for CandidateController
export default {
    getCandidates()
    {
        return fetchGet('/candidates-list');
    },
    contactCandidate(candidateId)
    {
        return fetchPost('/candidates-contact', candidateId);
    },
    hireCandidate(candidateId)
    {
        return fetchPost('/candidates-hire', candidateId);
    }
}