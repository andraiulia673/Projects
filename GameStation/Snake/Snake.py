import os
import pygame
import sys
import random

class Snake:
    def __init__(self, screen):
        self.running = True
        self.screen = screen
        self.width, self.height = 500, 500
        self.block_size = 50
        self.clock = pygame.time.Clock()

        font_path = os.path.join('./Others/assets/font.ttf')
        self.font_text = pygame.font.Font(font_path, 20)
        self.back_font = pygame.font.Font(font_path, 15)

        self.snake = self.Body(self)
        self.apple = self.Apple(self)

        self.score_rect = self.font_text.render('1', True, 'white').get_rect(center=(400, 20))

        self.back_button = pygame.Rect(10, 10, 100, 40)

        self.eat_sound = pygame.mixer.Sound('Snake/eat.mp3')
        self.gameover_sound = pygame.mixer.Sound('Snake/gameover.mp3')

    class Body:
        def __init__(self, game):
            self.game = game
            self.x, self.y = game.block_size, game.block_size
            self.x_dir, self.y_dir = 1, 0
            self.head = pygame.Rect(self.x, self.y, game.block_size, game.block_size)
            self.body = [pygame.Rect(self.x - game.block_size, self.y, game.block_size, game.block_size)]
            self.gameover = False

            self.head_img = pygame.image.load('Snake/snake_head.png').convert_alpha()
            self.head_img = pygame.transform.scale(self.head_img, (game.block_size, game.block_size))

        def update(self):
            for square in self.body:
                if self.head.x == square.x and self.head.y == square.y:
                    self.gameover = True
            if self.head.x not in range (0, self.game.width) or self.head.y not in range(0, self.game.height):
                self.gameover = True

            if self.gameover:
                self.game.gameover_sound.play()
                self.x, self.y = self.game.block_size, self.game.block_size
                self.head = pygame.Rect(self.x, self.y, self.game.block_size, self.game.block_size)
                self.body = [pygame.Rect(self.x - self.game.block_size, self.y, self.game.block_size, self.game.block_size)]
                self.x_dir, self.y_dir = 1, 0
                self.gameover = False
                self.game.apple = self.game.Apple(self.game)

            self.body.append(self.head)
            for i in range(len(self.body) - 1):
                self.body[i].x, self.body[i].y = self.body[i + 1].x, self.body[i + 1].y
            self.head.x += self.x_dir * self.game.block_size
            self.head.y += self.y_dir * self.game.block_size
            self.body.remove(self.head)

    class Apple:
        def __init__(self, game):
            self.game = game
            self.x = int(random.randint(0, game.width) / game.block_size) * game.block_size
            self.y = int(random.randint(0, game.height) / game.block_size) * game.block_size
            self.rect = pygame.Rect(self.x, self.y, game.block_size, game.block_size)
            self.image = pygame.image.load('Snake/apple.png').convert_alpha()
            self.image = pygame.transform.scale(self.image, (game.block_size, game.block_size))
        def update(self):
            self.game.screen.blit(self.image, (self.rect.x + 150, self.rect.y + 50))

    def grid(self):
        for i in range(0, self.width, self.block_size):
            for j in range(0, self.height, self.block_size):
                rect = pygame.Rect(i + 150, j + 50, self.block_size, self.block_size)
                pygame.draw.rect(self.screen, '#3c3c3b', rect, 1)

    def run(self):
        while self.running:
            for event in pygame.event.get():
                if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE):
                    self.exit_game()
                    return
                if event.type == pygame.KEYDOWN:
                    if event.key == pygame.K_DOWN:
                        self.snake.x_dir, self.snake.y_dir = 0, 1
                    elif event.key == pygame.K_UP:
                        self.snake.x_dir, self.snake.y_dir = 0, -1
                    elif event.key == pygame.K_RIGHT:
                        self.snake.x_dir, self.snake.y_dir = 1, 0
                    elif event.key == pygame.K_LEFT:
                        self.snake.x_dir, self.snake.y_dir = -1, 0
                if event.type == pygame.MOUSEBUTTONDOWN:
                    if self.back_button.collidepoint(event.pos):
                        return

            self.snake.update()
            self.screen.fill('purple')
            self.grid()
            self.apple.update()

            score = self.font_text.render(f"{len(self.snake.body) + 1}", True, "white")
            self.screen.blit(score, self.score_rect)

            pygame.draw.rect(self.screen, 'green', pygame.Rect(self.snake.head.x + 150, self.snake.head.y + 50, self.block_size, self.block_size))
            self.screen.blit(self.snake.head_img, (self.snake.head.x+150, self.snake.head.y+50))
            for square in self.snake.body:
                pygame.draw.rect(self.screen, 'green', pygame.Rect(square.x + 150, square.y + 50, self.block_size, self.block_size))
                    
            if self.snake.head.x == self.apple.x and self.snake.head.y == self.apple.y:
                self.snake.body.append(pygame.Rect(square.x, square.y, self.block_size, self.block_size))
                self.eat_sound.play()
                self.apple = self.Apple(self)

            pygame.draw.rect(self.screen, 'white', self.back_button)
            back_text = self.back_font.render('Back', True, (0, 0, 0))
            self.screen.blit(back_text, (self.back_button.x + 20, self.back_button.y + 10))
            pygame.display.update()
            self.clock.tick(5)

    def exit_game(self):
        self.running = False
        pygame.quit()
        sys.exit()