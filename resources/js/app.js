// import './bootstrap';


// const body = document.querySelector('body');
// const menu = document.querySelector('.profile')

// const headerMenu = document.querySelector('#user-menu-button');

// headerMenu.addEventListener('click', function() {
//     const menu = document.querySelector('.header-menu');
//     menu.classList.toggle('active');
// })

// body.addEventListener('click', function(e) {
//     console.log('test', e.target.parentNode);
//     // console.log(menu);

//     // if( === menu) console.log('child');

//     // if(e.target == headerMenu) return 
//     // const menu = document.querySelector('.header-menu');
//     // if(menu.classList.contains('active')) {
//     //     menu.classList.remove('active')
//     // }
// })


const body = document.querySelector('body');
const popup = document.querySelector('.popup-default');
const points = document.querySelectorAll('.points');

const popupOpen = () => {
    popup.classList.add('active');
    body.classList.add('fixed');
    documentDestroy();
}

const popupClose = () => {
    popup.classList.remove('active');
    body.classList.remove('fixed');
}

// Points
if(points) {
    points.forEach(p => {
        p.addEventListener('click', async (e) => {
            const target = e.target;
            const id = target.dataset.id;
            const user_id = document.querySelector('[name="user_id"]').value;
            const table_id = document.querySelector('[name="table_id"]').value;
    
            const response = await fetch('/api/question/'+id);
            const res = await response.json();
            const options = res.data.options.split('|');

            let points = 0;

            try {
                const token = "jJsoyYPsmn15!aagu";
                const uresponse = await fetch(`/api/user/${user_id}/question/${id}/table/${table_id}/${token}`);
                const ures = await uresponse.json();

                if(ures.data.points) points = ures.data.points; 
            } catch (e) {
                console.log('Не удалось найти баллы данной критерии');
            }

            
    
            const htmlData = `
                <div class="popup-criteria">
                    <span class="popup-criteria__title">Критерии оценки:</span>
                    <ul class="popup-criteria__list">
                        ${options.map(el => `<li>${el}</li>`).join('')}
                    </ul>
    
                    <div class="popup-criteria__row">
                        <label class="popup-criteria__title">Баллы:</label>
                        <input type="number" min="0" name="points" value="${points}" class="popup-criteria__input">
                    </div>
                </div>
            `;
    
            popup.querySelector('[name="question_id"]').value = id;
            const criteria = popup.querySelector('.popup-criteria');
            const doc = popup.querySelector('.popup-documents');
            const title = popup.querySelector('.popup__title');
            if(criteria) criteria.remove();
            if(doc) doc.remove();
    
            title.textContent = 'Изменение баллов';
            title.insertAdjacentHTML('afterend', htmlData);
            popupOpen();
        });
    })
}



const documents = document.querySelectorAll('.documents');
// Documents 
if(documents) {
    documents.forEach(p => {
        p.addEventListener('click', async (e) => {
            e.preventDefault();
            const target = e.currentTarget;
            const id = target.dataset.id;
            const user_id = document.querySelector('[name="user_id"]').value;
            const table_id = document.querySelector('[name="table_id"]').value;
            const token = "jJsoyYPsmn15!aagu";
            const response = await fetch(`/api/documents/user/${user_id}/question/${id}/table/${table_id}/${token}`);
            const {data: documents} = await response.json();
            
            // return console.log(user_id);
            
            
            const htmlDocuments = `
                <ul class="popup-documents__list" style="padding-left: 0">
                    ${documents?.map(el => `<li style="display: flex; justify-content: space-between;"><a href="storage/${el.path}" target="_blank">${el.name}</a>
                    <form><button data-user-id="${user_id}" data-document-id="${el.id}" class="document__destroy">Удалить</button></form>
                    </li>`).join('')}
                </ul>
            `;

            const htmlData = `
                <div class="popup-documents">
                    <span class="popup-criteria__title">Документы:</span>
                    ${documents ? htmlDocuments : '<div style="margin-bottom: 10px;">Не найдено</div>'}
                    <input type="file" name="files[]" class="files" multiple>
                </div>
            `;
    
            popup.querySelector('[name="question_id"]').value = id;
            const criteria = popup.querySelector('.popup-criteria');
            const doc = popup.querySelector('.popup-documents');
            const title = popup.querySelector('.popup__title');
            if(criteria) criteria.remove();
            if(doc) doc.remove();
    
            title.textContent = 'Изменение документов';
            title.insertAdjacentHTML('afterend', htmlData);

            popupOpen();
        });
    })
}


const documentDestroy = () => {
    const links = document.querySelectorAll(`.document__destroy`);

    if(links) {
        links.forEach(link => {
            link.addEventListener('click', async (e) => {
                e.preventDefault();
                const target = e.target;
                console.log(target, target.dataset.documentId);

                const headers = new Headers({
                    'Content-Type': 'application/json'
                });

                let response = await fetch('api/documents/destroy', {
                    method: 'POST',
                    body: JSON.stringify({user_id: Number(target.dataset.userId), document_id: Number(target.dataset.documentId)}),
                    headers: headers
                })
                response = await response.json();
            
                if(response.status) {
                    alert('Документ успешно удален');
                    document.querySelector(`button[data-document-id="${target.dataset.documentId}"]`).closest('li').remove();
                    document.querySelector(`a[data-document-id="${target.dataset.documentId}"]`).remove();
                    // loadDocumnet(response.data, formData.get('question_id'));
                    // popupClose();
                } else {
                    alert(response.message);
                }
            })
        })
    }
}




const loadDocumnet = (data, question_id) => {
    const block = document.querySelector(`[data-id="${question_id}"].documents`);
    let htmlDocuments = `<div class="documents__wrap">${data.map(el => `<a href="storage/${el.path}" data-document-id="${el.id}">${el.name}</a>`).join('')}</div>`;

    if(!block.childNodes.length) {
        htmlDocuments = `${data.map(el => `<a href="storage/${el.path}" target="_blank" data-document-id="${el.id}">${el.name}</a>`).join('')}`;
    }

    console.log('find - ', block);
    block.insertAdjacentHTML("afterbegin", htmlDocuments);
}


const uploadDocument = async () => {
    const formData = new FormData(document.querySelector('.form'));

    let response = await fetch('api/documents/upload', {
        method: 'POST',
        body: formData,
    })
    response = await response.json();

    if(response.status && Array.isArray(response.data)) {
        alert('Документы добавлены!');
        loadDocumnet(response.data, formData.get('question_id'));
        popupClose();
    }
    else {
        alert(response.message);
    }
}



const popupCloseBtn = document.querySelector('.popup__close');

if(popupCloseBtn) {
    popupCloseBtn.addEventListener('click', (e) => {
        e.preventDefault();
        popupClose();
    })
}


const popupSend = document.querySelector('.popup__btn');

if(popupSend) {
    popupSend.addEventListener('click', async (e) => {
        e.preventDefault();

        const form = new FormData(e.target.parentNode);
        const formData = {user_id: form.get('user_id'), question_id: form.get('question_id'), table_id: form.get('table_id'), points: form.get('points')};

        const isDocument = document.querySelector('.popup-documents');
        if(isDocument) {
            uploadDocument();
            return;
        }
        
        const headers = new Headers({
            'Content-Type': 'application/json'
        });

        const response = await fetch('api/question/store', {
            method: 'post',
            body: JSON.stringify(formData),
            headers: headers
        });
        const data = await response.json();

        // return console.log(data);

        if(data.status === true) {
            alert('Изменения сохранены!');
            document.querySelector(`[data-id="${form.get('question_id')}"]`).textContent = form.get('points');
        }
        else {
            alert(data.message);
        }
    })
}


// Comments

const commentsPopup = document.querySelector('.popup-comments');
const commentsPopupClose = document.querySelector('.popup-comments .popup__close');
const comments = document.querySelectorAll('.comments');


const loadComments = async (id, user_id) => {
    let response = await fetch(`api/comments/${id}/${user_id}`, {
        method: 'get',
    })
    response = await response.json();

    return response.data;
}

comments.forEach(link => {
    link.addEventListener('click', async (e) => {
        commentsPopup.classList.add('active');
        body.classList.add('fixed');

        const target = e.currentTarget;
        const id = target.dataset.id;
        const user_id = document.querySelector('[name="user_id"]').value;
        const comments = await loadComments(id, user_id);

        const commentsWrap = document.querySelector('.popup-comments__list');
        commentsWrap.innerHTML = "";

        let comment = "";

        if(comments) {
            comment = `${comments.map(com => `
                <li>
                    <div class="popup-comments__wrap">
                        <span class="popup-comments__curator"><span>Куратор</span> <span>${new Date(com.created_at).toLocaleString("ru")}</span></span>
                        <span class="popup-comments__message">${com.text}</span>
                    </div>
                </li>`).join('')}
            `;
        }else {
            comment = "Ничего не найдено";
        }

        

        // `${data.map(el => `<a href="storage/${el.path}" target="_blank" data-document-id="${el.id}">${el.name}</a>`).join('')}`;

        commentsWrap.insertAdjacentHTML("afterbegin", comment)

    });
});

commentsPopupClose.addEventListener('click', (e) => {
    commentsPopup.classList.remove('active');
    body.classList.remove('fixed');
});

