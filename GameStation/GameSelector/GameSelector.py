import os
import pygame
import sys
from Cars.Cars import Cars
from Pong.Pong import Pong
from Snake.Snake import Snake
from Others.ImageButton import ImageButton

class GameSelector:
    def __init__(self, screen):
        pygame.init()
        pygame.mixer.init()
        self.running = True

        self.screen = screen
        self.clock = pygame.time.Clock()

        font_path = os.path.join('./Others/assets/font.ttf')
        self.font = pygame.font.Font(font_path, 36)
        self.font_text = pygame.font.Font(font_path, 24)
        self.font_title = pygame.font.Font(font_path, 45)

        self.cars_button = ImageButton(os.path.join(os.path.dirname(__file__), 'car.png'), (150, 300), 2)
        self.pong_button = ImageButton(os.path.join(os.path.dirname(__file__), 'pong.png'), (450, 300), 2)
        self.snake_button = ImageButton(os.path.join(os.path.dirname(__file__), 'snake.png'), (700, 300))

    def run(self):
        while self.running:
            self.select_menu()
            self.clock.tick(60)

    def select_menu(self):
        self.screen.fill((147, 112, 219))
        title_text = self.font_title.render("Select game", True, (200, 180, 220))
        title_rect = title_text.get_rect(center=(400, 120))
        self.screen.blit(title_text, title_rect)

        mouse_pos = pygame.mouse.get_pos()
        for event in pygame.event.get():
            if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE):
                self.exit_game()
            if event.type == pygame.MOUSEBUTTONDOWN:
                if self.cars_button.is_clicked(mouse_pos):
                    self.start_cars()
                if self.pong_button.is_clicked(mouse_pos):
                    self.start_pong()
                if self.snake_button.is_clicked(mouse_pos):
                    self.start_snake()

        self.cars_button.draw(self.screen)
        self.pong_button.draw(self.screen)
        self.snake_button.draw(self.screen)

        cars_text = self.font_text.render("Highway run", True, (255, 255, 255))
        cars_rect = cars_text.get_rect(center=(self.cars_button.rect.centerx, self.cars_button.rect.bottom + 20))
        self.screen.blit(cars_text, cars_rect)

        pong_text = self.font_text.render("Pong-Pong", True, (255, 255, 255))
        pong_rect = pong_text.get_rect(center=(self.pong_button.rect.centerx, self.pong_button.rect.bottom + 20))
        self.screen.blit(pong_text, pong_rect)

        snake_text = self.font_text.render("Snake", True, (255, 255, 255))
        snake_rect = snake_text.get_rect(center=(self.snake_button.rect.centerx, self.snake_button.rect.bottom + 35))
        self.screen.blit(snake_text, snake_rect)

        pygame.display.update()

    def start_cars(self):
        pygame.mixer.music.stop()
        cars_game = Cars(self.screen)
        cars_game.run()
        pygame.mixer.music.load('./GameLauncher/intro.wav')
        pygame.mixer.music.play(-1)

    def start_pong(self):
        pygame.mixer.music.stop()
        pong_game = Pong(self.screen)
        pong_game.run()
        pygame.mixer.music.load('./GameLauncher/intro.wav')
        pygame.mixer.music.play(-1)

    def start_snake(self):
        pygame.mixer.music.stop()
        snake_game = Snake(self.screen)
        snake_game.run()
        pygame.mixer.music.load('./GameLauncher/intro.wav')
        pygame.mixer.music.play(-1)

    def exit_game(self):
        self.running = False
        pygame.quit()
        sys.exit()

