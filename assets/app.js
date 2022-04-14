import './styles/app.css';
import './bootstrap';
/*import TomSelect from 'tom-select';

async function jsonFetch (url) 
{
    const response = await fetch(url, {
        headers: {
            Accept: 'applications/json'
        }
    })

    if (response.status == 204) {
        return null;
    }

    if (response.ok) {
        return await response.json()
    }

    throw response
}

/**
 * @param {HTMLSelectElement} select 
 */

/*
function bindSelect(select) 
{
    new TomSelect(select, {
        hideSelected: true,
        closeAfterSelect: true,
        valueProperty: 'id',
        labelProperty: 'name',
        searchProperty: 'name',
        plugins: {
            remove_button: {title: ''}
        },
        load: async (query, callback) => {
            const url = `${select.dataset.remote}?q=${encodeURIComponent(query)}`
            callback(await jsonFetch(url))
        }
    })
}

Array.from(document.querySelectorAll('select[multiple]')).map(bindSelect)*/