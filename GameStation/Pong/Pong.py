import os
import pygame
import sys
import random

class Pong:
    def __init__(self, screen):
        self.running = True
        self.screen = screen
        self.screen_width = screen.get_width()
        self.screen_height = screen.get_height()
        self.clock = pygame.time.Clock()

        self.background = pygame.image.load('Pong/bg.jpg').convert()
        self.background = pygame.transform.scale(self.background, (800, 600))

        font_path = os.path.join('./Others/assets/font.ttf')
        self.back_font = pygame.font.Font(font_path, 15)
        self.score_font = pygame.font.Font('./Others/assets/font.ttf', 40)

        self.back_button = pygame.Rect(10, 10, 100, 40)

        self.ball = pygame.Rect(0, 0, 30, 30)
        self.ball.center = (self.screen_width / 2, self.screen_height / 2)

        self.cpu = pygame.Rect(0, 0, 20, 100)
        self.cpu.centery = self.screen_height / 2

        self.player = pygame.Rect(0, 0, 20, 100)
        self.player.midright = (self.screen_width, self.screen_height / 2)

        self.ball_image = pygame.image.load('Pong/ball.png').convert_alpha()
        self.ball_image = pygame.transform.scale(self.ball_image, (30, 30))

        self.ball_speed_x = 6
        self.ball_speed_y = 6
        self.player_speed = 0
        self.cpu_speed = 3

        self.cpu_points = 0
        self.player_points = 0

        self.bounce1 = pygame.mixer.Sound('Pong/sound1.mp3')
        self.bounce2 = pygame.mixer.Sound('Pong/sound2.mp3')
        self.gameover_sound = pygame.mixer.Sound('Pong/gameover.mp3')

    def reset_ball(self):
        self.ball.x = self.screen_width / 2 - 15
        self.ball.y = random.randint(10, 100)
        self.ball_speed_x *= random.choice([-1, 1])
        self.ball_speed_y *= random.choice([-1, 1])

    def point_won(self, winner):
        if winner == "cpu":
            self.cpu_points += 1
            self.gameover_sound.play()
        if winner == "player":
            self.player_points += 1
        self.reset_ball()

    def animate_ball(self):
        self.ball.x += self.ball_speed_x
        self.ball.y += self.ball_speed_y

        if self.ball.bottom >= self.screen_height or self.ball.top <= 0:
            self.ball_speed_y *= -1

        if self.ball.right >= self.screen_width:
            self.point_won("cpu")

        if self.ball.left <= 0:
            self.point_won("player")

        if self.ball.colliderect(self.player) or self.ball.colliderect(self.cpu):
            self.ball_speed_x *= -1
            if self.ball.colliderect(self.player):
                self.bounce1.play()
            elif self.ball.colliderect(self.cpu):
                self.bounce2.play()

    def animate_player(self):
        self.player.y += self.player_speed

        if self.player.top <= 0:
            self.player.top = 0
        if self.player.bottom >= self.screen_height:
            self.player.bottom = self.screen_height

    def animate_cpu(self):
        if self.ball.centery <= self.cpu.centery:
            self.cpu_speed = -6
        if self.ball.centery >= self.cpu.centery:
            self.cpu_speed = 6

        self.cpu.y += self.cpu_speed

        if self.cpu.top <= 0:
            self.cpu.top = 0
        if self.cpu.bottom >= self.screen_height:
            self.cpu.bottom = self.screen_height

    def run(self):
        while True:
            for event in pygame.event.get():
                if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE):
                    self.exit_game()
                if event.type == pygame.KEYDOWN:
                    if event.key == pygame.K_UP:
                        self.player_speed = -6
                    if event.key == pygame.K_DOWN:
                        self.player_speed = 6
                if event.type == pygame.KEYUP:
                    if event.key == pygame.K_UP or event.key == pygame.K_DOWN:
                        self.player_speed = 0
                if event.type == pygame.MOUSEBUTTONDOWN:
                    if self.back_button.collidepoint(event.pos):
                        return

            self.animate_ball()
            self.animate_player()
            self.animate_cpu()

            self.screen.blit(self.background, (0, 0))

            cpu_score_surface = self.score_font.render(str(self.cpu_points), True, "white")
            player_score_surface = self.score_font.render(str(self.player_points), True, "white")
            self.screen.blit(cpu_score_surface, (self.screen_width / 4, 20))
            self.screen.blit(player_score_surface, (3 * self.screen_width / 4, 20))

            pygame.draw.aaline(self.screen, 'white', (self.screen_width / 2, 0), (self.screen_width / 2, self.screen_height))
            self.screen.blit(self.ball_image, self.ball)
            pygame.draw.rect(self.screen, 'white', self.cpu)
            pygame.draw.rect(self.screen, 'white', self.player)

            pygame.draw.rect(self.screen, 'white', self.back_button)
            back_text = self.back_font.render('Back', True, (0, 0, 0))
            self.screen.blit(back_text, (self.back_button.x + 20, self.back_button.y + 10))
            pygame.display.update()
            self.clock.tick(60)

    def exit_game(self):
        self.running = False
        pygame.quit()
        sys.exit()
