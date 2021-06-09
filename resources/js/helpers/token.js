class Token {
    payload(token){
        let payloadSplit = token.split('.')
        let payload = token.split('.')[1]
        return JSON.parse(atob(payload))
    }

    isValid(token){
        try
        {
            let payload = this.payload(token)
            return payload ? baseURL.some((validISS) => {
                return payload.iss == validISS
            }) : false
        }catch (err){
            return false
        }

    }
}

export default new Token()
