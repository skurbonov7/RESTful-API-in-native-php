const $button = document.querySelector('#btn')
$button.addEventListener('click', addPost)

async function getPosts() {
    let res = await fetch('http://apiphp/nativePHP/posts');
    let posts = await res.json();


    posts.forEach(post => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">${post.title}</h5>
                    <p class="card-text">${post.body}/p>
                    <a href="#" class="card-link">Подробнее</a>
                </div>
            </div>
        `;
    });
}



async function addPost(){
    const title = document.querySelector('#title').value
        body = document.querySelector('#body').value
    
    let formData = new FormData();
    formData.append('title', title)
    formData.append('body', body)
    const res = await fetch('http://apiphp/nativePHP/posts', {
        method: 'POST',
        body: formData
    })

    const data = res.json();
    console.log(data);
}


getPosts();