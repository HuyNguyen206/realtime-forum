class Token {
    payload(token){
        let payload = token.split('.')[1]
        return JSON.parse(atob(payload))
    }

    isValid(token){
        let payload = this.payload(token)
        return payload ? baseURL.some((validISS) => {
            return payload.iss == validISS
        }) : false
    }
}

export default new Token()
