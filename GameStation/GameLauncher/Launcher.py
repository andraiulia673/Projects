import os
import pygame
import time
import sys
from Others.button import Button
from GameSelector.GameSelector import GameSelector

class GameLauncher:
    def __init__(self):
        pygame.init()
        pygame.mixer.init()
        self.running = True

        self.screen = pygame.display.set_mode((800, 600))
        self.clock = pygame.time.Clock()

        pygame.display.set_caption("Game Station")
        self.current_scene = "menu"

        font_path = os.path.join('./Others/assets/font.ttf')
        self.font = pygame.font.Font(font_path, 36)
        self.font_intro = pygame.font.Font(font_path, 40)
        self.font_title = pygame.font.Font(font_path, 45)

        self.bg_image = pygame.image.load('GameLauncher/menu_bg.jpg').convert()

        self.start_button = Button(None, (400, 300), "Start", self.font, (200, 0, 220), (200, 200, 200))
        self.exit_button = Button(None, (400, 400), "Exit", self.font, (200, 0, 220), (200, 200, 200))
        self.x = 0

    def run(self):
        self.play_music('GameLauncher/intro.wav')
        self.play_intro()
        while self.running:
            if self.current_scene == "menu":
                self.main_menu()
            elif self.current_scene == "selector":
                self.run_game_selector()
            self.clock.tick(60)
        pygame.quit()
        sys.exit()

    @staticmethod
    def play_music(path):
        pygame.mixer.music.load(path)
        pygame.mixer.music.play(-1)

    @staticmethod
    def stop_music():
        pygame.mixer.music.stop()

    def play_intro(self):
        text = self.font_intro.render("Game Station", True, (255, 100, 203))
        text_rect = text.get_rect(center=(400, 300))
        for alpha in range(0, 256, 5):
            self.screen.fill((255, 200, 220))
            text.set_alpha(alpha)
            self.screen.blit(text, text_rect)
            pygame.display.update()
            pygame.time.delay(30)
        time.sleep(2)

    def main_menu(self):
        rel_x = self.x % self.bg_image.get_rect().width
        self.screen.blit(self.bg_image, (rel_x - self.bg_image.get_rect().width, 0))
        if rel_x < 800:
            self.screen.blit(self.bg_image, (rel_x, 0))
        self.x -= 1

        title_text = self.font_title.render("Game station", True, (200, 100, 220))
        title_rect = title_text.get_rect(center=(400, 150))
        self.screen.blit(title_text, title_rect)

        mouse_pos = pygame.mouse.get_pos()
        for event in pygame.event.get():
            if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE):
                self.exit_game()
            if event.type == pygame.MOUSEBUTTONDOWN:
                if self.start_button.checkForInput(mouse_pos):
                    self.start_game_selector()
                if self.exit_button.checkForInput(mouse_pos):
                    self.exit_game()

        self.start_button.changeColor(mouse_pos)
        self.exit_button.changeColor(mouse_pos)

        self.start_button.update(self.screen)
        self.exit_button.update(self.screen)

        pygame.display.update()
        self.clock.tick(120)

    def run_game_selector(self):
        selector = GameSelector(self.screen)
        selector.run()
        self.current_scene = "menu"

    def start_game_selector(self):
        self.current_scene = "selector"

    def exit_game(self):
        self.running = False
        pygame.quit()
        sys.exit()


