import axios from "axios";

async function ApiService (props)  {
    const {method, url, data, params, callBack} = props

    switch (method) {
        case 'post': {
            return await axios.post(url, data, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then( (response) =>  {
                    if (response.data.message) {
                        sendSuccessToastr(response.data.message)
                    }
                    if (callBack) {
                        callBack()
                    }
                    return response.data
                })
                .catch( (error) => {
                    sendErrorToastr(error.response.data.error.message)
                    return false
                });
        }
        case 'getList': {
            const Params = new URLSearchParams(params)
            return await axios.get(`${url}${params.length ?  '?' + Params : ''}`, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then( (response) =>  {
                if (response.data.message) {
                    sendSuccessToastr(response.data.message)
                }
                if (callBack) {
                    callBack()
                }
                return  response.data
            })
                .catch( (error) => {
                    sendErrorToastr(error.response.data.error.message)
                    return false
                });
        }
        case 'patch': {
            const Params = new URLSearchParams(params)
            return await axios.patch(`${url}${params.length ?  '?' + Params : ''}`, data ? data : {} ,{
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.data.message) {
                    sendSuccessToastr(response.data.message)
                }
                if (callBack) {
                    callBack()
                }
                return  response.data
            })
                .catch(error => {
                    sendErrorToastr(error.response.data.error.message)
                    return false
                })
        }
        case 'delete': {
            const Params = new URLSearchParams(params)

            return await axios.delete(`${url}${params.length ?  '?' + Params : ''}`,{
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.data.message) {
                    sendSuccessToastr(response.data.message)
                }
                if (callBack) {
                    callBack()
                }
                return  response.data
            })
                .catch(error => {
                    sendErrorToastr(error.response.data.error.message)
                    return false
                })
        }
        case 'postData': {
            return await axios.post(url, data, {
            })
                .then( (response) =>  {
                    if (response.data.message) {
                        sendSuccessToastr(response.data.message)
                    }
                    if (callBack) {
                        callBack()
                    }
                    return response.data
                })
                .catch( (error) => {
                    sendErrorToastr(error.response.data.error.message)
                    return false
                });
        }

    }
}


export default ApiService;