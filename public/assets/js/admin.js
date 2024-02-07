
const deleteBtn = document.querySelectorAll('.delete-btn');
const routeDelete = document.querySelector('.delete-route');

if(deleteBtn) {

  deleteBtn.forEach(el => el.addEventListener('click', (e) => {
    e.preventDefault();
    const id = Number(el.previousElementSibling.value);
    const action = confirm('Вы точно хотите удалить ?');

    if(action) {
      customFetch(routeDelete.action, id);
    }
  }));
}

function customFetch(route, id) {

  fetch(route,{
      method: 'POST',
      body: JSON.stringify({id: id}),
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
  }
  ).then(resp => {return resp.json()}).then(res => {

    console.log(res);
    if(res.status == true) {
      window.location.reload();
    }
  });


};


// Баллы пользователя

const points = document.querySelectorAll('.points');

points.forEach(link => link.addEventListener('click', async function(e) {
  e.preventDefault();

  document.querySelector('[name="question_id"]').value = this.dataset.id;
  document.querySelector('[name="question_curator_id"]').value = this.dataset.question_curator_id;

  const points = document.querySelector('#pointsInput');
  const options = document.querySelector('.points-options');
  
  let pointsDefault = 0;

  const target = this;
  const id = target.dataset.id;
  const user_id = document.querySelector('[name="user_id"]').value;
  const table_id = document.querySelector('[name="table_id"]').value;

  const response = await fetch('/api/question/'+id);
  const res = await response.json();

  let option = await fetch('/api/question/'+id+'/options');
  option = await option.json();

  if(!res.status) return;

  try {
      const token = "jJsoyYPsmn15!aagu";
      const uresponse = await fetch(`/api/user/${user_id}/question/${id}/table/${table_id}/${token}`);
      const ures = await uresponse.json();

      option = option.data.split('|');
      const optionList = `
        <ul style="padding-left:0px; list-style: none;">
            ${option.map(el => `<li>${el.trim()}</li>`).join('')}
        </ul>`;

      // console.log(optionList);
      options.innerHTML = optionList;

      if(ures.data.points) pointsDefault = ures.data.points; 
  } catch (e) {
      console.log('Не удалось найти баллы данной критерии');
  }


  points.value = pointsDefault;
  $('#pointsModal').modal('show');
}));

const pointsChange = document.querySelector('#pointsChange');

if(pointsChange) {
  pointsChange.addEventListener('click', async function(e) {
    e.preventDefault();
  
    const points = document.querySelector('#pointsInput');
    const user_id = document.querySelector('[name="user_id"]').value;
  
    const question_id = document.querySelector('[name="question_id"]').value;
    const question_curator_id = document.querySelector('[name="question_curator_id"]').value;
  
    const curator_id = document.querySelector('[name="curator_id"]').value;
    const table_id = document.querySelector('[name="table_id"]').value;
  
    const formData = {user_id, question_id, table_id, question_curator_id, curator_id, points: points.value};
  
    const headers = new Headers({
      'Content-Type': 'application/json'
    });
  
  
    const response = await fetch('/api/admin/question/store', {
        method: 'post',
        body: JSON.stringify(formData),
        headers: headers
    });
    const data = await response.json();
  
    if(data.status === true) {
      alert('Изменения сохранены!');
      document.querySelector(`[data-id="${question_id}"]`).textContent = points.value;
    }else {
      alert(data.message);
    }
  
  });
}



// DOCUMENTS

const documents = document.querySelectorAll('.documents');
const documentsList = document.querySelectorAll('.documents-list');


const sendDocument = document.querySelector('.document-upload');

if(sendDocument) {
  sendDocument.addEventListener('click', async (e) => {
    e.preventDefault();

    const question_id = document.querySelector('[name="question_id"]').value;
    const user_id = document.querySelector('[name="user_id"]').value;
    const question_curator_id = document.querySelector('[name="question_curator_id"]').value;
  
    const curator_id = document.querySelector('[name="curator_id"]').value;
    const table_id = document.querySelector('[name="table_id"]').value;

    const formData = new FormData(document.querySelector('.upload-form-user'));

    formData.append('user_id', user_id);
    formData.append('question_id', question_id);
    formData.append('question_curator_id', question_curator_id);
    formData.append('table_id', table_id);
    formData.append('curator_id', curator_id);
  
    let response = await fetch(`/api/admin/document/store`, {
      method: 'POST',
      body: formData,
    });
  
    response = await response.json();

    console.log(response);
  
    if(response.status) {
      alert('Документы успешно добавлены');
      loadDocumnetsLinks(question_id, response.data);
      const load = await loadDocumnets(question_id, user_id, table_id);

    }else {
      alert(response.message);
    }
  });
}

const loadDocumnetsLinks = (question_id, data) => {
  const wrap = document.querySelector(`.documents[data-id="${question_id}"]`);
  const wrapInner = wrap.querySelector('.documents__wrap');


  const html = data.map(el => `<a href="/storage/${el.path}" target="_blank" data-document-id="${el.id}" class="text-hidden">${el.name}</a>`
    ).join('');
  const withWrap = `<div class="documents__wrap">${html}</div>`;

  if(!wrapInner) {
    wrap.insertAdjacentHTML('afterbegin', withWrap);
  } else {
    wrapInner.insertAdjacentHTML('afterbegin', html);
  }
}


const loadDocumnets = async (question_id, user_id, table_id) => {

  document.querySelector('.documents-list').innerHTML = "";
  
  const token = "jJsoyYPsmn15!aagu";
  const response = await fetch(`/api/documents/user/${user_id}/question/${question_id}/table/${table_id}/${token}`);
  const data = await response.json();



  if(!data.status) {
    console.log('Документов не найдено');
    const html = `<tr><td>Документов не найдено</td></tr>`;
    document.querySelector('.documents-list').insertAdjacentHTML('afterbegin', html);
  }

  if(data.status) {
    const html = data.data.map(el => `
      <tr>
        <td style="width:100%">${el.name}</td>
        <td class="text-right py-0 align-middle">
            <div class="btn-group btn-group-sm">
                <a href="/storage/${el.path}" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i></a>
                <button class="btn btn-danger document__destroy" data-user-id="${user_id}" data-document-id="${el.id}"><i class="fas fa-trash"></i></button>
            </div>
        </td>
      </tr>`
      ).join('');

      document.querySelector('.documents-list').insertAdjacentHTML('afterbegin', html);
  }

  return data;
}



documents.forEach(link => link.addEventListener('click', async function(e) {
  e.preventDefault();
  const user_id = document.querySelector('[name="user_id"]').value;
  const table_id = document.querySelector('[name="table_id"]').value;
  const question_id = this.dataset.id;

  document.querySelector('[name="question_id"]').value = question_id;
  document.querySelector('[name="question_curator_id"]').value = this.dataset.question_curator_id;

  const load = await loadDocumnets(question_id, user_id, table_id);

  $('#documentsModal').modal('show');
}));


const documentsRemove = document.querySelectorAll('.document__destroy');


if(documentsList) {

  documentsList.forEach(link => link.addEventListener('click', async function(e) {
    const target = e.target;
    if(!target.classList.contains('document__destroy')) return;

    const user_id = target.dataset.userId;
    const document_id = target.dataset.documentId;

    const question_id = document.querySelector('[name="question_id"]').value;
    const question_curator_id = document.querySelector('[name="question_curator_id"]').value;

    const curator_id = document.querySelector('[name="curator_id"]').value;
    const table_id = document.querySelector('[name="table_id"]').value;

    const headers = new Headers({
      'Content-Type': 'application/json'
    });

    const data = {user_id: Number(user_id), document_id: Number(document_id), question_curator_id: Number(question_curator_id), curator_id: Number(curator_id)};

    let response = await fetch('/api/admin/documents/destroy', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: headers
    })
    response = await response.json();

    console.log(response);

    if(response.status) {
        alert('Документ успешно удален');
        document.querySelector(`a[data-document-id="${document_id}"]`).remove();
        const load = await loadDocumnets(question_id, user_id, table_id);
    }else {
      alert(response.message);
    }

  }));

}


// COMMENTS

const loadComments = async (question_id, user_id, table_id) => {

  document.querySelector('.comments-list').innerHTML = "";

  let response = await fetch(`/api/comments/${question_id}/${user_id}`, {
    method: 'get',
  })
  response = await response.json();

  // return console.log(response);


  if(!response.status) {
    const html = `<p>Комментариев не найдено</p>`;
    document.querySelector('.comments-list').insertAdjacentHTML('afterbegin', html);
  }

  if(response.status) {
    const html = response.data.map(com => `
      <div class="post clearfix">
        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="/assets/admin/img/admin.svg" alt="User Image">
            <span class="username">
            <span>Куратор</span>
            <a href="#" class="float-right btn-tool delete-comment" data-id="${com.id}"><i class="fas fa-times"></i></a>
            </span>
            <span class="description">Дата: ${new Date(com.created_at).toLocaleString("ru")}</span>
        </div>
        <p>${com.text}</p>
      </div>`
      ).join('');

      document.querySelector('.comments-list').insertAdjacentHTML('afterbegin', html);
  }

  return response;
}

const comments = document.querySelectorAll('.comments');

if(comments) {
  comments.forEach(link => link.addEventListener('click', async function(e) {
    e.preventDefault();
    
    document.querySelector('[name="comment"]').value = '';
  
    document.querySelector('[name="question_id"]').value = this.dataset.id;
    document.querySelector('[name="question_curator_id"]').value = this.dataset.question_curator_id;
  
    const user_id = document.querySelector('[name="user_id"]').value;
    const question_id = document.querySelector('[name="question_id"]').value;
    const question_curator_id = document.querySelector('[name="question_curator_id"]').value;
  
    const curator_id = document.querySelector('[name="curator_id"]').value;
    const table_id = document.querySelector('[name="table_id"]').value;
  
    const load = await loadComments(question_id, user_id, table_id);
  
  
    $('#commentsModal').modal('show');
  }));
  
}



const sendComment = document.querySelector('.send-comment');

if(sendComment) {
  sendComment.addEventListener('click', async (e) => {
    e.preventDefault();
  
    const user_id = document.querySelector('[name="user_id"]').value;
    const question_id = document.querySelector('[name="question_id"]').value;
    const question_curator_id = document.querySelector('[name="question_curator_id"]').value;
  
    const curator_id = document.querySelector('[name="curator_id"]').value;
    const table_id = document.querySelector('[name="table_id"]').value;
  
  
    const comment = document.querySelector('[name="comment"]').value;
  
    const data = {comment, user_id, question_id, question_curator_id, table_id, curator_id};
  
    console.log(data);
  
    const headers = new Headers({
      'Content-Type': 'application/json'
    });
  
    let response = await fetch(`/api/admin/comments/store`, {
      method: 'POST',
      body: JSON.stringify(data),
      headers: headers
    });
  
    response = await response.json();
  
    if(response.status) {
      alert('Комментарий успешно добавлен');
      document.querySelector('[name="comment"]').value = '';
      const field = document.querySelector(`.comments[data-id="${question_id}"] span`);
      const count = Number(field.textContent);
      field.textContent = count + 1;
      const load = await loadComments(question_id, user_id, table_id);
    }else {
      alert(response.message);
    }
  });
}


const deleteComment = document.querySelector('.tab-content');

if(deleteComment) {
  deleteComment.addEventListener('click', async (e) => {
    e.preventDefault();
  
    const target = e.target;
    if(!target.classList.contains('delete-comment')) return;
  
    const user_id = document.querySelector('[name="user_id"]').value;
    const question_id = document.querySelector('[name="question_id"]').value;
    const question_curator_id = document.querySelector('[name="question_curator_id"]').value;
  
    const curator_id = document.querySelector('[name="curator_id"]').value;
    const table_id = document.querySelector('[name="table_id"]').value;
  
    const headers = new Headers({
      'Content-Type': 'application/json'
    });
  
    const data = {id: target.dataset.id, user_id, question_id, question_curator_id, table_id, curator_id};
  
    let response = await fetch(`/api/admin/comment/destroy`, {
      method: 'POST',
      body: JSON.stringify(data),
      headers: headers
    });
  
    response = await response.json();
  
    if(response.status) {
      alert('Комментарий успешно удален');
      const field = document.querySelector(`.comments[data-id="${question_id}"] span`);
      const count = Number(field.textContent);
      field.textContent = count - 1;
      const load = await loadComments(question_id, user_id, table_id);
    }else {
      alert(response.message);
    }
  
  })
}



// ADD USERS

// const addUserTable = document.querySelector('.table-add-users');
const addUserBtn = document.querySelector('.add-user__btn');

if(addUserBtn) {

  addUserBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    const selectedUsers = document.querySelectorAll('.selected');
    const table_id = document.querySelector('[name="table_id"]').value;
    const selectedIds = [];

    selectedUsers.forEach(el => {
      selectedIds.push(Number(el.dataset.id));
    })

    console.log(selectedIds);

    const headers = new Headers({
      'Content-Type': 'application/json'
    });
  
    const data = {user_ids: selectedIds, table_id: Number(table_id)};

    let response = await fetch(`/api/admin/users/add`, {
      method: 'POST',
      body: JSON.stringify(data),
      headers: headers
    });
  
    response = await response.json();

    if(response.status) {
      alert(response.message);
      // console.log(response);
      location.reload();
    }

  })
  

  

}