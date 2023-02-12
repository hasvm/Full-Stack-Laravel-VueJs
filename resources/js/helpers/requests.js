// This are aux functions that can be used to set the configurations for the requests

async function fetchDefault(url, data, method) {
    const response = await fetch(url, {
        method,
        headers: {
            'Content-type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr
            ('content'),
        },
        body: JSON.stringify(data),
    });

    return response.json();
}

export async function fetchPost(url, data) {
    return await fetchDefault(url, data, 'post');
 }

 export async function fetchGet(url) {
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Content-type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr
            ('content'),
        },
    });

    return response.json();
 }