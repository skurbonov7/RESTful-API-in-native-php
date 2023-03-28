const $addPost = document.querySelector('#addPost');
const $upPost = document.querySelector('#upPost');

$addPost.addEventListener('click', addPost);
$upPost.addEventListener('click', updatePost);

let id = null;

async function getPosts() {
    let res = await fetch('http://apiphp/serverAPI/posts');
    let posts = await res.json();

    document.querySelector('.post-list').innerHTML = '';
    posts.forEach(post => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">${post.title}</h5>
                    <p class="card-text">${post.body}</p>
                    <a href="#" class="card-link">Подробнее</a>
                    <a href="#" id="remPost" class="card-link" onclick="removePost(${post.id})" >Удалит</a>
                    <a href="#" id="remPost" class="card-link" onclick="selectPost('${post.id}', '${post.title}', '${post.body}')" >Именит</a>
                </div>
            </div>
        `;
    });
}



async function addPost() {
    const title = document.querySelector('#title').value,
        body = document.querySelector('#body').value;

    let formData = new FormData();
    formData.append('title', title);
    formData.append('body', body);

    const res = await fetch('http://apiphp/serverAPI/posts', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.status === true) {
        await getPosts();
    }
}


async function removePost(id) {
    const res = await fetch(`http://apiphp/serverAPI/posts/${id}`, {
        method: 'DELETE'
    });
    const data = await res.json();

    if (data.status === true) {
        await getPosts();
    }
}

async function selectPost(id, title, body) {
    id = id
    document.querySelector('#title-edit').value = title,
    document.querySelector('#body-edit').value = body
}

async function updatePost() {

    const title = document.querySelector('#title-edit').value,
        body = document.querySelector('#body-edit').value
    
    const data = {
        title: title,
        body: body,
    }

    const res = await fetch(`http://apiphp/serverAPI/posts/${id}`, {
        method: "PATCH",
        body: JSON.stringify(data)
    });

    let resData = res.json();

    if (resData.status === true) {
        await getPosts();
    }
}

getPosts();