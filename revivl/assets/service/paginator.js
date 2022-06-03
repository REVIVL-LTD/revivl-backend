function paginator (pageCount, currentPage,  fillData, pagination, setCurrentPage) {
    pagination.innerHTML = ''
    for (let i = 1; i <= pageCount; i++) {
        if (i === 1 || i === pageCount || i === currentPage || (i === currentPage + 1) || (i === currentPage - 1)) {
            const page = document.createElement('div')
            page.classList.add('page-button')
            page.dataset.number = i
            page.innerHTML = `${i}`
            if (i === currentPage) {
                page.classList.add('_active')
            }
            const clickButton = () => {
                setCurrentPage(i)
                pagination.innerHTML = ''
                fillData()
            }
            page.addEventListener('click', clickButton)
            pagination.append(page)
        } else if ((i === currentPage -2) || (i === currentPage + 2)) {
            const dott = document.createElement('span')
            dott.innerHTML = '...'
            pagination.append(dott)

        }
    }
}

export default paginator