export default class User {

    static fromMap(data: Record<string, never>): User {
        return new User(
            data.name,
            data.email,
        )
    }

    private readonly name: string
    private readonly email: string

    constructor(name: string, email: string) {
        this.name = name
        this.email = email
    }
}
