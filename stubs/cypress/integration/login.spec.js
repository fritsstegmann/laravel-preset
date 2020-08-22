/// <reference types="cypress" />
describe('Login', () => {
    context('with valid credentials', () => {
        it('works', () => {
            expect(2 + 2).to.equal(4)
            cy.visit('/login')
        })
    })
})
