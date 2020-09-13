/// <reference types="cypress" />
describe('Login', () => {

    beforeEach(() => {
        cy.clearCookies()
    })

    // happy path
    context('with valid credentials', () => {
        it('works', () => {
            cy.login('test@example.com', 'password')
        })
    })

    // edge cases
    context('with invalid credentials', () => {
        it('requires a valid email address', () => {
            cy.visit('/login')

            cy.get('div').should('not.contain', 'The email must be a valid email address')

            cy
                .get('#email')
                .focus()
                .type('test%example.com')
                .blur()

            cy.get('#log-in-button').click()

            cy.contains('The email must be a valid email address')
        })
    })
})
