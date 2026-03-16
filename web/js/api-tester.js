let authToken = localStorage.getItem("token") || ""

if (authToken) {
    document.getElementById("token").textContent = authToken
}

function toggleForms() {

    const apiMethod = document.getElementById("apiMethod").value

    const postForm = document.getElementById("postForm")
    const listParams = document.getElementById("listParams")
    const idBlock = document.getElementById("idBlock")

    postForm.style.display = apiMethod === "create" ? "block" : "none"
    listParams.style.display = apiMethod === "list" ? "block" : "none"
    idBlock.style.display = apiMethod === "get" ? "block" : "none"

}

async function login() {

    const login = document.getElementById("login").value
    const password = document.getElementById("password").value

    try {

        const response = await fetch("/api/v1/auth/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                login: login,
                password: password
            })
        })

        const text = await response.text()

        let data

        try {
            data = JSON.parse(text)
        } catch {
            throw new Error("Server returned non JSON:\n" + text)
        }

        if (!response.ok) {
            throw new Error(JSON.stringify(data, null, 2))
        }

        if (!data.token) {
            throw new Error("Token not returned")
        }

        authToken = data.token

        localStorage.setItem("token", authToken)

        document.getElementById("token").textContent = authToken

    } catch (e) {

        document.getElementById("response").textContent = e

    }

}

async function sendRequest() {

    if (!authToken) {
        alert("Сначала выполните login")
        return
    }

    const apiMethod = document.getElementById("apiMethod").value

    let url = ""
    let method = "GET"

    if (apiMethod === "create") {
        url = "/api/v1/car/create"
        method = "POST"
    }

    if (apiMethod === "get") {

        const id = document.getElementById("car_id").value
        url = "/api/v1/car/" + id

    }

    if (apiMethod === "list") {

        const page = document.getElementById("page").value
        const pageSize = document.getElementById("pageSize").value
        const sort = document.getElementById("sort").value

        const params = new URLSearchParams()

        if (page) params.append("page", page)
        if (pageSize) params.append("pageSize", pageSize)
        if (sort) params.append("sort", sort)

        url = "/api/v1/car/list?" + params.toString()

    }

    try {

        let response

        if (method === "GET") {

            response = await fetch(url, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + authToken
                }
            })

        } else {

            const body = {

                title: document.getElementById("title").value,
                description: document.getElementById("description").value,
                price: parseFloat(document.getElementById("price").value),
                photo_url: document.getElementById("photo_url").value,
                contacts: document.getElementById("contacts").value,
                options: JSON.parse(document.getElementById("options").value)

            }

            response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + authToken
                },
                body: JSON.stringify(body)
            })

        }

        const text = await response.text()

        let data

        try {
            data = JSON.parse(text)
        } catch {
            document.getElementById("response").textContent = text
            return
        }

        if (!response.ok) {

            document.getElementById("response").textContent =
                "HTTP " + response.status + "\n\n" +
                JSON.stringify(data, null, 2)

            return

        }

        document.getElementById("response").textContent =
            JSON.stringify(data, null, 2)

    } catch (e) {

        document.getElementById("response").textContent = e

    }

}

toggleForms()