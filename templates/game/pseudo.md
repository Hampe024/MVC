function game_round(deck)

    player_cards += deck -> draw
    player_cards += deck -> draw

    loop:
        if sum of player_cards < 21:
            if wants more cards:
                player_cards += deck -> draw
            else:
                end loop
        else:
            end loop

    return sum of player_cards

---------------------------------------------------------

deck = new Deck

player1_score = game_round(deck)
player2_score = game_round(deck)

if player1_score > player2_score:
    player 1 won!
else:
    player 2 won!