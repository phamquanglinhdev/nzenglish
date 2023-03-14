$("#pre-create").change((e) => {
    let name = e.target.name
    let value = e.target.value
    window.location.href = "?" + name + "=" + value;
})
